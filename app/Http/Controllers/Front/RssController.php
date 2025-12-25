<?php

namespace App\Http\Controllers\Front;

use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class RssController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', PostStatus::Published->value)
            ->whereNotNull('updated_at')
            ->where('updated_at', '<=', now())
            ->orderByDesc('updated_at')
            ->take(30)
            ->get();

        return response()
            ->view('rss.xml', compact('posts'))
            ->header('Content-Type', 'application/rss+xml; charset=UTF-*');
    }
}
