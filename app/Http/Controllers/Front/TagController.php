<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\Category;
use App\Models\Post;
use App\Enums\PostStatus;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::withCount(['posts' => function ($q) {
            $q->where('status', PostStatus::Published->value)
                ->where('posts.updated_at', '<=', now());
        }])
            ->orderBy('name')
            ->get();

        return view('front.tags.index', compact('tags'));
    }

    public function show(Request $request, Tag $tag)
    {
        $query = $tag->posts()
            ->where('status', PostStatus::Published->value)
            ->where('posts.updated_at', '<=', now())
            ->with(['category', 'tags']);

        // Search
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%($search)%")
                    ->orWhere('excerpt', 'like', "%($search)%")
                    ->orWhere('content', 'like', "%($search)%");
            });
        }

        // Filter by Category slug
        if ($categorySlug = $request->get('category')) {
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // Sorting
        $sort = $request->get('sort', 'latest');

        if ($sort === 'oldest') {
            $query->orderBy('updated_at', 'asc');
        } else {
            $query->orderBy('updated_at', 'desc');
        }

        $posts = $query->paginate(9)->withQueryString();

        // Categories that actually have Posts with this Tag
        $categories = Category::whereHas('posts', function ($q) use ($tag) {
            $q->whereHas('tags', function ($q2) use ($tag) {
                $q2->where('tags.id', $tag->id);
            })
                ->where('status', PostStatus::Published->value)
                ->where('posts.updated_at', '<=', now());
        })
            ->orderBy('name')
            ->get();

        return view('front.tags.show', compact(
            'tag',
            'posts',
            'categories',
            'sort',
        ));
    }
}
