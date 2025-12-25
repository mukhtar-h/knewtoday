@extends('layouts.admin')

@section('title', 'View Message — Admin')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6 space-y-6">

    <div class="flex items-center justify-between gap-3">
        <h1 class="kt-section-title text-base">
            Contact message
        </h1>

        <a href="{{ route('admin.contact_messages.index') }}"
           class="kt-btn-outline text-[11px]">
            Back to list
        </a>
    </div>

    <div class="kt-card space-y-4 text-xs">
        {{-- From --}}
        <div class="flex flex-wrap justify-between gap-3">
            <div class="space-y-1">
                <p class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                    From
                </p>
                <p class="text-[12px] text-kt-text font-semibold">
                    {{ $contactMessage->name }}
                </p>
                <p class="text-[11px] text-kt-accent">
                    <a href="mailto:{{ $contactMessage->email }}" class="hover:underline">
                        {{ $contactMessage->email }}
                    </a>
                </p>
            </div>

            <div class="space-y-1 text-right">
                <p class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                    Received
                </p>
                <p class="text-[11px] text-kt-text">
                    {{ $contactMessage->created_at->toDayDateTimeString() }}
                </p>
                <p class="text-[10px] text-kt-muted">
                    {{ $contactMessage->created_at->diffForHumans() }}
                </p>
            </div>
        </div>

        {{-- Subject --}}
        <div class="space-y-1">
            <p class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                Subject
            </p>
            <p class="text-[12px] text-kt-text">
                {{ $contactMessage->subject ?: '—' }}
            </p>
        </div>

        {{-- Message --}}
        <div class="space-y-1">
            <p class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                Message
            </p>
            <div class="rounded-lg bg-kt-bg/80 border border-kt-border/80 px-3 py-3 text-[12px] leading-relaxed">
                {!! nl2br(e($contactMessage->message)) !!}
            </div>
        </div>

        {{-- Meta --}}
        <div class="grid gap-3 sm:grid-cols-2 text-[10px] text-kt-muted">
            <div>
                <p class="uppercase tracking-[0.18em] mb-1">
                    Status
                </p>

                <form method="POST" action="{{ route('admin.contact_messages.updateStatus', $contactMessage) }}" class="flex items-center gap-2">
                    @csrf
                    @method('PATCH')

                    <select name="status"
                            class="px-2 py-1 rounded-md bg-kt-bg border border-kt-border text-[11px] text-kt-textMuted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">
                        <option value="new" @selected($contactMessage->status === 'new')>New</option>
                        <option value="read" @selected($contactMessage->status === 'read')>Read</option>
                        <option value="archived" @selected($contactMessage->status === 'archived')>Archived</option>
                    </select>

                    <button type="submit"
                            class="px-2 py-1 rounded-md border border-kt-border text-[10px] text-kt-textMuted hover:border-kt-accent hover:text-kt-accent">
                        Update
                    </button>
                </form>
            </div>

            <div>
                <p class="uppercase tracking-[0.18em] mb-1">
                    Technical
                </p>
                <p>IP: {{ $contactMessage->ip_address ?? '—' }}</p>
                <p class="mt-1 break-all">
                    User agent: {{ $contactMessage->user_agent ?? '—' }}
                </p>
            </div>
        </div>

        {{-- Danger zone --}}
        <div class="pt-3 border-t border-kt-border/60 flex items-center justify-between gap-3 text-[11px]">
            <p class="text-kt-muted">
                Deleting this message cannot be undone.
            </p>
            <form method="POST" action="{{ route('admin.contact_messages.destroy', $contactMessage) }}"
                  onsubmit="return confirm('Delete this message permanently?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-3 py-1.5 rounded-lg border border-red-500/60 bg-red-500/10 text-[11px] text-red-200 hover:bg-red-500/20">
                    Delete
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
