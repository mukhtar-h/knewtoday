<?php

namespace App\Http\Controllers\Front;

use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount(['posts' => function ($q) {
            $q->where('status', PostStatus::Published->value)
                ->where('updated_at', '<=', now())
                ->with(['author', 'category'])
                ->latest('updated_at');
        }])->orderBy('name')->get();

        return view('front.categories.index', compact('categories'));
    }

    public function show(Request $request, Category $category)
    {
        $query = $category->posts()
            ->where('status', PostStatus::Published->value)
            ->where('updated_at', '<=', now())
            ->with(['tags', 'category']);

        // Search inside category posts
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Filter by tag (by slug)
        if ($tagSlug = $request->get('tag')) {
            $query->whereHas('tags', function ($q) use ($tagSlug) {
                $q->where('slug', $tagSlug);
            });
        }

        // Sort
        $sort = $request->get('sort', 'latest');

        if ($sort === 'oldest') {
            $query->orderBy('updated_at', 'asc');
        } else {
            // default: latest
            $query->orderBy('updated_at', 'desc');
        }

        $posts = $query->paginate(9)->withQueryString();

        // Tags actually used within this category (for filter dropdown)
        $tags = Tag::whereHas('posts', function ($q) use ($category) {
            $q->where('category_id', $category->id)
                ->where('status', PostStatus::Published->value);
        })
            ->orderBy('name')
            ->get();

        return view('front.categories.show', compact(
            'category',
            'posts',
            'tags',
            'sort'
        ));
    }
}
