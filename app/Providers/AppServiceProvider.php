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
            return "<?php echo \\App\\Support\\HtmlSanitizer::trix($expression); ?>";
        });
    }
}
