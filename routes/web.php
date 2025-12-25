<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ContactMessageAdminController;
use App\Http\Controllers\Admin\NewsletterSubscriberController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\PostController as FrontPostController;
use App\Http\Controllers\Front\CategoryController as FrontCategoryController;
use App\Http\Controllers\Front\TagController as FrontTagController;
use App\Http\Controllers\Front\CommentController as FrontCommentController;
use App\Http\Controllers\Front\ContactController as FrontContactController;
use App\Http\Controllers\Front\NewsletterController;
use App\Http\Controllers\Front\RssController;
use App\Http\Controllers\Front\SearchController;
use App\Http\Controllers\Front\SitemapController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/**
 * In the above route
 * later add 'verified' in the middleware beside 'auth'
 */

// Route::get('/dashboard', fn() => redirect()->route('profile.edit'))
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});



/**
 * Admin Routes
 */
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth'])
    ->group(function () {
        // Writers, Editors, Admins, SuperAdmins can access post section
        Route::middleware('role:writer, editor, admin, super_admin')
            ->group(function () {
                Route::resource('posts', PostController::class)
                    ->except(['show']);
            });

        // Only Admins & SuperAdmins manage Categories / Tags
        Route::middleware('role:writer, admin, super_admin')->group(function () {
            Route::resource('categories', CategoryController::class)->except(['show']);
            Route::resource('tags', TagController::class)->except(['show']);
            Route::resource('users', UserController::class)->except(['show', 'create', 'store']);

            Route::patch('/posts/{post}/status', [PostController::class, 'updateStatus'])
                ->name('posts.updateStatus');

            Route::patch('/posts/{post}/featured', [PostController::class, 'updateFeatured'])
                ->name('posts.updateFeatured');

            // Newsletter subscribers
            Route::get('/newsletter/subscribers', [NewsletterSubscriberController::class, 'index'])
                ->name('newsletter.subscribers.index');
            Route::get('/newsletter/subscribers/export', [NewsletterSubscriberController::class, 'export'])
                ->name('newsletter.subscribers.export');

            // Contact Messages
            Route::get('/contact-messages', [ContactMessageAdminController::class, 'index'])
                ->name('contact_messages.index');
            Route::get('/contact-messages/{contactMessage}', [ContactMessageAdminController::class, 'show'])
                ->name('contact_messages.show');

            Route::patch('/contact-messages/{contactMessage}/status', [ContactMessageAdminController::class, 'updateStatus'])
                ->name('contact_messages.updateStatus');

            Route::delete('/contact-messages/{contactMessage}', [ContactMessageAdminController::class, 'destroy'])
                ->name('contact_messages.destroy');

            Route::get('newsletter/send', [NewsletterSubscriberController::class, 'create'])
                ->name('newsletter.send.create');
            Route::post('/newsletter/send', [NewsletterSubscriberController::class, 'send'])
                ->name('newsletter.send.store');
        });

        // Editors, Admins, SuperAdmins manage Comments
        Route::middleware('role:editor, admin, super_admin')->group(function () {
            Route::resource('comments', CommentController::class)->only(['index', 'update', 'destroy']);
        });
    });

/**
 * Public Routes
 */
Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/stories', [FrontPostController::class, 'index'])
    ->name('front.posts.index');
Route::get('/stories/{post:slug}', [FrontPostController::class, 'show'])
    ->name('front.posts.show');

Route::get('/categories', [FrontCategoryController::class, 'index'])
    ->name('front.categories.index');
Route::get('/categories/{category:slug}', [FrontCategoryController::class, 'show'])
    ->name('front.categories.show');

Route::get('/tags', [FrontTagController::class, 'index'])
    ->name('front.tags.index');
Route::get('/tags/{tag:slug}', [FrontTagController::class, 'show'])
    ->name('front.tags.show');

Route::get('/search', [SearchController::class, 'index'])
    ->name('front.search');


Route::post('/stories/{post:slug}/comments', [FrontCommentController::class, 'store'])
    ->name('front.comment.store');

// About: static for now
Route::view('/about', 'front.about')->name('front.about');

// Contact: show + submit
Route::get('/contact', [FrontContactController::class, 'show'])
    ->name('front.contact');
Route::post('/contact', [FrontContactController::class, 'submit'])
    ->name('front.contact.submit')
    ->middleware('throttle:5,1'); // max 5 submissions per minute per IP

// Sitemap + RSS
// Sitemap
Route::get('/sitemap.xml', [SitemapController::class, 'index'])
    ->name('sitemap');

// RSS Feed
Route::get('/rss.xml', [RssController::class, 'index'])
    ->name('rss');

// Subscriber
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])
    ->name('newsletter.subscribe');

Route::get('/newsletter/unsubscribe/{subscriber}/{token}', [NewsletterController::class, 'unsubscribe'])
    ->name('newsletter.unsubscribe.link');

// Cookies and Policy
Route::view('/cookies', 'front.cookies')->name('front.cookies');
Route::view('/privacy', 'front.privacy')->name('front.privacy');

// Notification
Route::middleware(['auth'])->group(function () {
    // Notification list
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    // Go to notification target (marks as read and redirects)
    Route::get('/notifications/{notification}/go', [NotificationController::class, 'go'])
        ->name('notifications.go')
        ->whereUuid('notification');

    // Mark a single notification as read
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.read')
        ->whereUuid('notification');

    // Mark all as read
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])
        ->name('notifications.readAll');

    // Delete a notification
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])
        ->name('notifications.destroy')
        ->whereUuid('notification');
});

require __DIR__ . '/auth.php';
