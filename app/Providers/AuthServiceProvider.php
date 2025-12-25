<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Policies\CategoryPolicy;
use App\Policies\CommentPolicy;
use App\Policies\PostPolicy;
use App\Policies\TagPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
// use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    // protected $policies = [
    //     // Map Model::class to Policy::class
    //     Post::class     => PostPolicy::class,
    //     Comment::class  => CommentPolicy::class,
    // ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::policy(Post::class, PostPolicy::class);
        Gate::policy(Category::class, CategoryPolicy::class);
        Gate::policy(Tag::class, TagPolicy::class);
        Gate::policy(Comment::class, CommentPolicy::class);

        Gate::define('admin', function ($user) {
            return in_array($user->role->value, [
                'super_admin',
                'admin',
            ]);
        });

        Gate::define('writer', function ($user) {
            return in_array($user->role->value, [
                'super_admin',
                'admin',
                'editor',
                'writer',
            ]);
        });
    }
}
