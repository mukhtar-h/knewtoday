<?php

namespace App\Http\Controllers;

use App\Enums\NewsletterStatus;
use App\Enums\PostStatus;
use App\Models\Comment;
use App\Models\NewsletterSubscriber;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $isAdmin = Gate::allows('manage-users');

        $adminStats = null;
        $userStats = null;

        if ($isAdmin) {
            $adminStats = [
                'total_posts'       => Post::count(),
                'published_posts'   => Post::where('status', PostStatus::Published->value)->count(),
                'draft_posts'       => Post::where('status', PostStatus::Draft->value)->count(),
                'total_comments'    => Comment::count(),
                'total_users'       => User::count(),
                'newsletter_subs'   => NewsletterSubscriber::where('status', NewsletterStatus::Subscribed->value)->count(),
            ];
        }

        // Personal stats for any logged-in users
        $userPostsQuery = Post::where('user_id', $user->id);

        $userStats = [
            'my_posts'              => $userPostsQuery->count(),
            'my_published_posts'    => (clone $userPostsQuery)->where('status', PostStatus::Published->value)->count(),
            'my_drafts'             => (clone $userPostsQuery)->where('status', PostStatus::Draft->value)->count(),
            'comments_on_my_posts'  => Comment::whereHas('post', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->count(),
        ];

        return view('dashboard', compact('user', 'isAdmin', 'adminStats', 'userStats'));
    }
}
