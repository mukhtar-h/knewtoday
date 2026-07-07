<?php

namespace App\Http\Controllers\Admin;

use App\Enums\NewsletterStatus;
use App\Http\Controllers\Controller;
use App\Mail\NewsletterBroadcast;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class NewsletterSubscriberController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('admin');

        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', Rule::in(NewsletterStatus::options())],
        ]);

        $query = NewsletterSubscriber::query();

        // Filter
        if ($searchTerm = trim($filters['search'] ?? '')) {
            $likeSearchTerm = '%'.addcslashes($searchTerm, '\\%_').'%';

            $query->where(function ($subscriberQuery) use ($likeSearchTerm) {
                $subscriberQuery->where('email', 'like', $likeSearchTerm)
                    ->orWhere('name', 'like', $likeSearchTerm);
            });
        }

        if ($status = $filters['status'] ?? null) {
            $query->where('status', $status);
        }

        $subscribers = $query
            ->orderByDesc('subscribed_at')
            ->orderByDesc('created_at')
            ->paginate(25)
            ->withQueryString();

        // Counts for quick stats
        $stats = [
            'total' => NewsletterSubscriber::count(),
            'subscribed' => NewsletterSubscriber::where('status', NewsletterStatus::Subscribed)->count(),
            'unsubscribed' => NewsletterSubscriber::where('status', NewsletterStatus::Unsubscribed)->count(),

        ];

        return view('admin.newsletter.subscribers.index', compact('subscribers', 'stats'));
    }

    public function export(Request $request)
    {
        Gate::authorize('admin');

        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', Rule::in(NewsletterStatus::options())],
        ]);

        $query = NewsletterSubscriber::query();

        if ($searchTerm = trim($filters['search'] ?? '')) {
            $likeSearchTerm = '%'.addcslashes($searchTerm, '\\%_').'%';

            $query->where(function ($subscriberQuery) use ($likeSearchTerm) {
                $subscriberQuery->where('email', 'like', $likeSearchTerm)
                    ->orWhere('name', 'like', $likeSearchTerm);
            });
        }

        if ($status = $filters['status'] ?? null) {
            $query->where('status', $status);
        }

        $fileName = 'newsletter-subscribers-'.now()->format('Y-m-d_H-i').'.csv';

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');

            // Header
            fputcsv($handle, ['Email', 'Name', 'Status', 'Subscribed At', 'Unsubscribed At', 'Created At']);

            $query->orderByDesc('subscribed_at')
                ->orderByDesc('created_at')
                ->chunk(200, function ($chunk) use ($handle) {
                    foreach ($chunk as $subscriber) {
                        fputcsv($handle, [
                            $subscriber->email,
                            $subscriber->name,
                            $subscriber->status,
                            optional($subscriber->subscribed_at)->toDateTimeString(),
                            optional($subscriber->unsubscribed_at)->toDateTimeString(),
                            optional($subscriber->created_at)->toDateTimeString(),
                        ]);
                    }
                });

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function create()
    {
        Gate::authorize('admin');

        return view('admin.newsletter.subscribers.send');
    }

    public function send(Request $request)
    {
        Gate::authorize('admin');

        $data = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'min:10'],
        ]);

        $subject = $data['subject'];
        $content = $data['content'];

        NewsletterSubscriber::where('status', 'subscribed')
            ->orderBy('id')
            ->chunk(100, function ($subscribers) use ($subject, $content) {
                foreach ($subscribers as $subscriber) {
                    Mail::to($subscriber->email)->send(
                        new NewsletterBroadcast($subscriber, $subject, $content)
                    );
                }
            });

        return redirect()
            ->route('admin.newsletter.send.create')
            ->with('success', 'Newsletter sent to all active subscribers.');
    }
}
