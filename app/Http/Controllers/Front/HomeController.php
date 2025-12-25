<?php

namespace App\Http\Controllers\Front;

use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Base query: published posts only
        $published = Post::where('status', PostStatus::Published->value)
            ->whereNotNull('updated_at')
            ->where('updated_at', '<=', now());

        // Hero featured post
        $heroPost = (clone $published)
            ->where('is_featured', true)
            ->latest('updated_at')
            ->first()
            ?? (clone $published)->latest('updated_at')->first();

        // Secondary featured posts 2 Posts
        $featuredPosts = collect();
        if ($heroPost) {
            $featuredPosts = (clone $published)
                ->where('is_featured', true)
                ->where('id', '!=', $heroPost->id)
                ->latest('updated_at')
                ->take(2)
                ->get();
        }

        // Latest posts
        $latestPosts = (clone $published)
            ->latest('updated_at')
            ->take(6)
            ->get();

        // Most viewed this week - for now we'll just resuse latest posts;
        // Later we add a 'views' column and change this
        $mostViewedPosts = (clone $published)
            ->latest('updated_at')
            ->take(4)
            ->get();

        // Popular tags & categories for future sections / sidebar if needed
        $popularTags = Tag::withCount('posts')
            ->orderByDesc('posts_count')
            ->take(8)
            ->get();

        $categories = Category::withCount('posts')
            ->orderBy('name')
            ->get();

        return view('front.home', compact(
            'heroPost',
            'featuredPosts',
            'latestPosts',
            'mostViewedPosts',
            'popularTags',
            'categories'
        ));
    }
}
