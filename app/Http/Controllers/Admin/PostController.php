<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Mail\PostPublishedNewsletter;
use App\Models\Category;
use App\Models\NewsletterSubscriber;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Post::class);

        $query = Post::with(['author', 'category'])->latest('updated_at');

        if ($request->filled('search')) {
            $data = $request->validate([
                'search' => ['required', 'string', 'max:100'],
            ]);

            $searchTerm = trim($data['search']);
            $likeSearchTerm = '%'.addcslashes($searchTerm, '\\%_').'%';

            $query->where(function ($postQuery) use ($likeSearchTerm) {
                $postQuery->where('title', 'like', $likeSearchTerm)
                    ->orWhere('slug', 'like', $likeSearchTerm)
                    ->orWhereHas('author', function ($authorQuery) use ($likeSearchTerm) {
                        $authorQuery->where('name', 'like', $likeSearchTerm);
                    });
            });
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($categoryId = $request->get('category_id')) {
            $query->where('category_id', $categoryId);
        }

        $posts = $query->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();
        $statuses = PostStatus::options();

        return view('admin.posts.index', compact('posts', 'categories', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Post::class);

        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        $statuses = PostStatus::options();

        return view('admin.posts.create', compact('categories', 'tags', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Post::class);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'thumbnail' => ['nullable', 'image', 'max:2048'], // 2MB
            'tags' => ['nullable', 'string', 'max:500'],
        ]);

        $data['user_id'] = $request->user()->id;
        $data['is_featured'] = $request->boolean('is_featured');

        // Generate from title
        $data['slug'] = $this->uniqueSlug($data['title']);

        // New Posts are always draft
        $data['status'] = PostStatus::Draft->value ?? 'draft';

        // Handling thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail_path'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        // Simple reading time estimate: 200 words per minute
        $wordCount = str_word_count(strip_tags($data['content']));
        $data['reading_time'] = max(1, (int) ceil($wordCount / 200));

        // Remove Tags from $data (tags is not a column)
        $tagsInput = $data['tags'] ?? null;
        unset($data['tags']);

        $post = Post::create($data);

        // Sync tags
        $this->syncTags($post, $tagsInput);

        return redirect()
            ->route('admin.posts.edit', $post)
            ->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        $statuses = PostStatus::options();

        return view('admin.posts.edit', compact('post', 'categories', 'tags', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'thumbnail' => ['nullable', 'image', 'max:2048'], // 2MB
            'tags' => ['nullable', 'string', 'max:500'],
        ]);

        // If Post title is changed, regenerate slug
        if ($post->title !== $data['title']) {
            $data['slug'] = $this->uniqueSlug($data['title'], $post);
        }

        // Thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($post->thumbnail_path) {
                Storage::disk('public')->delete($post->thumbnail_path);
            }

            $data['thumbnail_path'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        // Word count
        $wordCount = str_word_count(strip_tags($data['content']));
        $data['reading_time'] = max(1, (int) ceil($wordCount / 200));

        // Unsetting tags
        $tagsInput = $data['tags'] ?? null;
        unset($data['tags']);

        $post->update($data);

        // Syncing Tags
        $this->syncTags($post, $tagsInput);

        return redirect()
            ->route('admin.posts.edit', $post)
            ->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('status', 'Post deleted.');
    }

    /**
     * Private function for Post Tags sync
     *
     * @param  mixed  $tagsInput
     */
    private function syncTags(Post $post, ?string $tagsInput): void
    {
        $tagsInput = $tagsInput ?? '';

        $names = collect(explode(',', $tagsInput))
            ->map(fn ($tag) => trim($tag))
            ->filter()
            ->unique();

        if ($names->isEmpty()) {
            $post->tags()->sync([]);

            return;
        }

        $tagIds = [];

        foreach ($names as $name) {
            $slug = Str::slug($name);

            $tag = Tag::firstOrCreate(
                ['slug' => $slug],
                ['name' => $name]
            );

            $tagIds[] = $tag->id;
        }

        $post->tags()->sync($tagIds);
    }

    public function updateStatus(Request $request, Post $post)
    {
        $this->authorize('changeStatus', $post);

        $data = $request->validate([
            'status' => ['required', 'string', Rule::in(PostStatus::options())],
        ]);

        $wasPublished = $post->status === PostStatus::Published;
        $post->status = PostStatus::from($data['status']);
        $post->save();

        // If status changed from Not Published to Published, send Newsletter
        if (! $wasPublished && $post->status === PostStatus::Published) {
            $this->sendPostPublishedNewsletter($post);
        }

        return back()->with(
            'success',
            'Post status updated to '.str_replace('_', ' ', $post->status->value).'.'
        );
    }

    public function updateFeatured(Request $request, Post $post)
    {
        $this->authorize('changeStatus', $post);

        $post->is_featured = $request->boolean('is_featured');
        $post->save();

        return back()->with('success', 'Post featured flag updated.');
    }

    protected function sendPostPublishedNewsletter(Post $post)
    {
        NewsletterSubscriber::where('status', 'subscribed')
            ->orderBy('id')
            ->chunk(100, function ($subscribers) use ($post) {
                foreach ($subscribers as $subscriber) {
                    if (! $subscriber->unsubscribe_token) {
                        $subscriber->unsubscribe_token = \Illuminate\Support\Str::random(40);
                        $subscriber->save();
                    }

                    Mail::to($subscriber->email)->send(
                        new PostPublishedNewsletter($subscriber, $post)
                    );
                }
            });
    }

    private function uniqueSlug(string $title, ?Post $ignorePost = null): string
    {
        $baseSlug = Str::slug($title) ?: 'post';
        $slug = $baseSlug;
        $suffix = 2;

        while (
            Post::where('slug', $slug)
                ->when($ignorePost, fn ($query) => $query->whereKeyNot($ignorePost->id))
                ->exists()
        ) {
            $slug = $baseSlug.'-'.$suffix;
            $suffix++;
        }

        return $slug;
    }
}
