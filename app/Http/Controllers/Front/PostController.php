<?php

namespace App\Http\Controllers\Front;

use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {


        $postsQuery = Post::query()
            ->where('status', PostStatus::Published->value)
            ->where('updated_at', '<=', now())
            ->with(['author', 'category', 'tags']);

        // Search (title, excerpt, content)
        if ($request->filled('search')) {
            $data = $request->validate([
                'search' => ['required', 'string', 'max:100'],
            ]);

            $searchTerm = trim($data['search']);
            $searchTerm = '%' . $searchTerm . '%';

            $postsQuery->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                    ->orWhere('excerpt', 'like', $searchTerm)
                    ->orWhere('content', 'like', $searchTerm);
            });
        }

        // Feature Posts
        if ($request->filled('featured')) {
            $request->validate([
                'featured' => ['sometimes', 'in:1'],
            ]);

            $postsQuery->when($request->has('featured'), function ($query) {
                return $query->where('is_featured', true);
            });
        }


        // Filter by Category (slug)
        if ($categorySlug = $request->get('category')) {
            $postsQuery->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // Filter by Tag (slug)
        if ($tagSlug = $request->get('tag')) {
            $postsQuery->whereHas('tags', function ($q) use ($tagSlug) {
                $q->where('slug', $tagSlug);
            });
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $postsQuery->orderBy('updated_at', 'asc');
                break;

            case 'latest':
            default:
                $postsQuery->orderBy('updated_at', 'desc');
                break;

                // Later we will code for filtering Post by pupolarity
        }

        $posts = $postsQuery->paginate(9)->withQueryString();

        // For filter dropdowns
        $categories = Category::orderBy('name')->get();
        $tags       = Tag::orderBy('name')->get();

        return view('front.posts.index', compact('posts', 'categories', 'tags', 'sort'));
    }

    public function show(Request $request, Post $post)
    {

        // Only allow viewing published Posts
        if (
            $post->status !== PostStatus::Published
        ) {
            abort(403);
        }

        $post->load([
            'author',
            'category',
            'tags',

            // Top level Comments
            'comments' => function ($query) {
                $query->approved()
                    ->whereNull('parent_id')
                    ->latest();
            },
            // Load the User for top level Comments
            'comments.user',

            // Load nested Replies
            'comments.replies' => function ($query) {
                $query->approved()
                    ->oldest();
            },

            // Load the User for the Reply
            'comments.replies.user',
        ]);


        // Approved top-level comments with approved children
        $comments = $post->comments;

        // Simple related Posts with same Category and status published but this one Post
        $relatedPosts = Post::where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->where('status', PostStatus::Published->value)
            ->where('updated_at', '<=', now())
            ->latest('updated_at')
            ->take(3)
            ->get();

        return view('front.posts.show', compact('post', 'comments', 'relatedPosts'));
    }
}
