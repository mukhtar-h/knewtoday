@extends('layouts.admin')

@section('title', 'Contact Messages — Admin')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6 space-y-6">

    {{-- Header + filters --}}
    <div class="flex flex-wrap items-center justify-between gap-3">
        <h1 class="kt-section-title text-base">
            Contact Messages
        </h1>

        <form method="GET" action="{{ route('admin.contact_messages.index') }}"
            class="flex flex-wrap items-center gap-2 text-[11px]">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Search name, email, subject..."
                class="px-2 py-1 rounded-md bg-kt-bg border border-kt-border text-[11px] text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent" />

            @php
            $currentStatus = request('status');
            @endphp
            <select name="status"
                class="px-2 py-1 rounded-md bg-kt-bg border border-kt-border text-[11px] text-kt-textMuted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">
                <option value="">All statuses</option>
                <option value="new" @selected($currentStatus==='new' )>New</option>
                <option value="read" @selected($currentStatus==='read' )>Read</option>
                <option value="archived" @selected($currentStatus==='archived' )>Archived</option>
            </select>

            <button type="submit" class="kt-btn-outline text-[11px]">
                Apply
            </button>
        </form>
    </div>

    {{-- Table --}}
    <div class="kt-card p-0 overflow-hidden">
        <table class="w-full border-collapse text-xs">
            <thead>
                <tr class="text-[11px] text-kt-muted border-b border-kt-border/70">
                    <th class="py-2 px-3 text-left">From</th>
                    <th class="py-2 px-3 text-left">Subject</th>
                    <th class="py-2 px-3 text-left">Status</th>
                    <th class="py-2 px-3 text-left">Received</th>
                    <th class="py-2 px-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $message)
                <tr class="border-b border-kt-border/40">
                    <td class="py-2 px-3 align-top">
                        <div class="flex flex-col">
                            <span class="text-[11px] text-kt-text font-medium">
                                {{ $message->name }}
                            </span>
                            <span class="text-[10px] text-kt-muted">
                                {{ $message->email }}
                            </span>
                        </div>
                    </td>
                    <td class="py-2 px-3 align-top text-kt-text">
                        <span class="text-[11px]">
                            {{ $message->subject ?: '—' }}
                        </span>
                        <p class="text-[10px] text-kt-muted mt-0.5 line-clamp-1">
                            {{ \Illuminate\Support\Str::limit($message->message, 80) }}
                        </p>
                    </td>
                    <td class="py-2 px-3 align-top text-kt-textMuted text-[11px]">
                        @php
                        $label = ucfirst($message->status);
                        $class = match ($message->status) {
                        'new' => 'bg-kt-bg border-kt-accent/60 text-kt-accent',
                        'read' => 'bg-kt-bg border-kt-border text-kt-textMuted',
                        'archived' => 'bg-slate-500/10 border-slate-500/40 text-slate-300',
                        default => 'bg-kt-bg border-kt-border text-kt-textMuted',
                        };
                        @endphp
                        <span class="inline-flex items-center rounded-full border px-2 py-0.5 text-[10px] {{ $class }}">
                            {{ $label }}
                        </span>
                    </td>
                    <td class="py-2 px-3 align-top text-[10px] text-kt-muted whitespace-nowrap">
                        {{ $message->created_at->diffForHumans() }}
                    </td>
                    {{-- Message View --}}
                    <td class="py-2 px-3 align-top text-right text-[11px]">
                        <a href="{{ route('admin.contact_messages.show', $message) }}"
                            class="text-kt-accent hover:underline">
                            View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-4 px-3 text-center text-[11px] text-kt-textMuted">
                        No contact messages found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $messages->links() }}
    </div>
</div>
@endsection