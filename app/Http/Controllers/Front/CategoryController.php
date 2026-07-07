<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount(['posts' => function ($postQuery) {
            $postQuery->published();
        }])->orderBy('name')->get();

        return view('front.categories.index', compact('categories'));
    }

    public function show(Request $request, Category $category)
    {
        $query = $category->posts()
            ->published()
            ->with(['tags', 'category']);

        // Search inside category posts
        if ($search = $request->get('search')) {
            $query->matchingSearch($search);
        }

        // Filter by tag (by slug)
        if ($tagSlug = $request->get('tag')) {
            $query->whereHas('tags', function ($tagQuery) use ($tagSlug) {
                $tagQuery->where('slug', $tagSlug);
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
        $tags = Tag::whereHas('posts', function ($postQuery) use ($category) {
            $postQuery
                ->where('category_id', $category->id)
                ->published();
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
