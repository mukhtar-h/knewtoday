<?php

namespace App\Http\Controllers\Front;

use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', PostStatus::Published->value)
            ->whereNotNull('updated_at')
            ->where('updated_at', '<=', now())
            ->orderByDesc('updated_at')
            ->get();

        $categories = Category::orderBy('name')->get();
        $tags       = Tag::orderBy('name')->get();

        return response()
            ->view('sitemap.xml', compact('posts', 'categories', 'tags'))
            ->header('Content-Type', 'application/xml');
    }
}
