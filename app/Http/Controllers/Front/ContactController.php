<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        return view('front.contact');
    }

    public function submit(Request $request)
    {

        // simple honeypot: real users never see/fill this
        if ($request->filled('website')) {
            // quietly pretend success (do NOT throw validation error, it's a bot)
            return back()->with('success', 'Thank you, your message has been received.');
        }

        $data = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255'],
            'subject'   => ['nullable', 'string', 'max:255'],
            'message'   => ['required', 'string', 'min:10', 'max:4000'],
        ]);

        $data['ip_address'] = $request->ip();
        $data['user_agent'] = $request->userAgent();

        $contactMessage = ContactMessage::create($data);

        // Refreshing Cache
        Cache::forget('new_messages_count');

        // Send notification email to site owner
        $to = config('mail.contact_to') ?? config('mail.from.address');

        if ($to) {
            Mail::to($to)->send(new ContactMessageReceived($contactMessage));
        }

        return back()->with('success', 'Thank you, your message has been received. We’ll get back to you soon.');
    }
}
