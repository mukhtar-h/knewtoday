<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::withCount(['posts' => function ($postQuery) {
            $postQuery->published();
        }])
            ->orderBy('name')
            ->get();

        return view('front.tags.index', compact('tags'));
    }

    public function show(Request $request, Tag $tag)
    {
        $query = $tag->posts()
            ->published()
            ->with(['category', 'tags']);

        // Search
        if ($search = $request->get('search')) {
            $query->matchingSearch($search);
        }

        // Filter by Category slug
        if ($categorySlug = $request->get('category')) {
            $query->whereHas('category', function ($categoryQuery) use ($categorySlug) {
                $categoryQuery->where('slug', $categorySlug);
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
        $categories = Category::whereHas('posts', function ($postQuery) use ($tag) {
            $postQuery->whereHas('tags', function ($tagQuery) use ($tag) {
                $tagQuery->where('tags.id', $tag->id);
            })
                ->published();
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
