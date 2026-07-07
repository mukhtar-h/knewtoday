<?php

namespace App\Http\Controllers\Front;

use App\Enums\NewsletterStatus;
use App\Http\Controllers\Controller;
use App\Mail\NewsletterWelcome;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'name' => ['nullable', 'string', 'max:255'],
        ]);

        $email = strtolower($data['email']);
        $subscriber = NewsletterSubscriber::where('email', $email)->first();

        if (! $subscriber) {
            $subscriber = NewsletterSubscriber::create([
                'email' => $email,
                'name' => $data['name'] ?? null,
                'status' => 'subscribed',
                'unsubscribe_token' => Str::random(40),
                'subscribed_at' => now(),
            ]);
        } else {
            // Already exists: re-subscribe if previously unsubscribed
            if (trim($subscriber->status->value) === 'unsubscribed') {
                $subscriber->status = NewsletterStatus::Subscribed;
                $subscriber->subscribed_at = now();
                $subscriber->unsubscribed_at = null;
            }

            if (! $subscriber->unsubscribe_token) {
                $subscriber->unsubscribe_token = Str::random(40);
            }

            $subscriber->name = $data['name'] ?? $subscriber->name;
            $subscriber->save();
        }

        // Send welcome mail
        Mail::to($subscriber->email)->send(new NewsletterWelcome($subscriber));

        return back()->with('success', 'You have been subscribed to our newsletter.');
    }

    public function unsubscribe(NewsletterSubscriber $subscriber, string $token)
    {
        if (! hash_equals((string) $subscriber->unsubscribe_token, (string) $token)) {
            // Wrong token: prevent guessing

            throw ValidationException::withMessages([
                'newsletter' => 'Invalid unsubscribe link.',
            ]);
        }

        $subscriber->status = NewsletterStatus::Unsubscribed;
        $subscriber->unsubscribed_at = now();
        $subscriber->save();

        return redirect()
            ->route('home')
            ->with('success', 'You have been unsubscribed form the newsletter.');
    }
}
