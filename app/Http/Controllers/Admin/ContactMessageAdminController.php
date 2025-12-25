<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ContactMessageAdminController extends Controller
{
    public function index(Request $request)
    {
        $messages = ContactMessage::query()
            ->when(
                $request->filled('status'),
                fn($query) => $query->status($request->query('status'))
            )
            ->when(
                $request->filled('search'),
                fn($query) => $query->search($request->query('search'))
            )
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.contact_messages.index', compact('messages'));
    }

    public function show(ContactMessage $contactMessage)
    {

        if ($contactMessage->status === 'new') {
            $contactMessage->update(['status' => 'read']);
        }

        // Refreshing Cache
        Cache::forget('new_messages_count');


        return view('admin.contact_messages.show', compact('contactMessage'));
    }

    public function updateStatus(Request $request, ContactMessage $contactMessage)
    {

        $data = $request->validate([
            'status' => [
                'required',
                Rule::in(['new', 'read', 'archived']),
            ],
        ]);

        Log::info('Attempting to update message ID ' . $contactMessage->id . ' from ' . $contactMessage->status . ' to ' . $data['status']);

        $contactMessage->update($data);

        // Refreshing Cache
        Cache::forget('new_messages_count');

        return redirect()
            ->route('admin.contact_messages.index')
            ->with('success', 'Message status updated.');
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();

        // Refreshing Cache
        Cache::forget('new_messages_count');

        return redirect()
            ->route('admin.contact_messages.index')
            ->with('success', 'Message deleted.');
    }
}
