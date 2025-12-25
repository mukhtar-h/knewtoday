<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $unread = $user->unreadNotifications()
            ->orderByDesc('created_at')
            ->get();

        $notifications = $user->notifications()
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('notifications.index', [
            'user'          => $user,
            'unread'        => $unread,
            'notifications' => $notifications,
        ]);
    }

    public function go(DatabaseNotification $notification)
    {
        $this->authorizeNotification($notification);

        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        $url = $notification->data['url'] ?? null;

        if ($url) {
            return Redirect::to($url);
        }

        return back()->with('success', 'Notification marked as read.');
    }

    public function markAsRead(DatabaseNotification $notification)
    {
        $this->authorizeNotification($notification);

        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        return back()->with('success', 'Notification marked as read.');
    }

    public function markAllAsRead(Request $request)
    {
        $user = Auth::user();

        $user->unreadNotifications->markAsRead();

        return back()->with('success', 'All notifications marked as read.');
    }

    public function destroy(DatabaseNotification $notification)
    {
        $this->authorizeNotification($notification);

        $notification->delete();

        return back()->with('success', 'Notification removed.');
    }

    protected function authorizeNotification(DatabaseNotification $notification): void
    {
        $user = Auth::user();

        if (
            $notification->notifiable_id !== $user->getKey() ||
            $notification->notifiable_type !== get_class($user)
        ) {
            abort(403);
        }
    }
}
