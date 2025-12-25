<?php

namespace App\Providers;

use App\Models\ContactMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.admin', function ($view) {
            $user = Auth::user();

            if ($user && $user->can('admin')) {
                $newCount = Cache::remember('new_messages_count', 3600, function () {
                    return ContactMessage::where('status', 'new')->count();
                });
            } else {
                $newCount = 0;
            }
            $view->with('newContactMessagesCount', $newCount);
        });

        // Custom Blade Directive
        Blade::directive('trix', function ($expression) {
            $allowedTags = '<div><a><strong><b><em><ul><li><ol><p><br><h1><blockquote><pre>';

            return "<?php 
            \$content = strip_tags($expression, '$allowedTags');
            
            // Remove any attribute starting with 'on' (onclick, onmouseover, etc.)
            
            \$content = preg_replace('/on\w+\s*=\s*\"[^\"]*\"/i', '', \$content);
            
            
            // Remove javascript: pseudo-protocols in links
            
            \$content = preg_replace('/href\s*=\s*\"javascript:[^\"]*\"/i', 'href=\"#\"', \$content);
            
            echo nl2br(\$content); 
        ?>";
        });
    }
}
