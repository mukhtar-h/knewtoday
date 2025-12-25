@extends('layouts.app')

@section('title', 'Notifications — KNEWTODAY')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6 space-y-6">

    {{-- Header --}}
    <section class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="kt-section-title text-base">
                Notifications
            </h1>
            <p class="text-xs text-kt-textMuted">
                Updates about replies to your comments and other activity related to your account.
            </p>
        </div>

        @if($user->unreadNotifications()->count() > 0)
        <form method="POST" action="{{ route('notifications.readAll') }}">
            @csrf
            <button type="submit" class="kt-btn-outline text-[11px]">
                Mark all as read
            </button>
        </form>
        @endif
    </section>

    {{-- Unread section --}}
    <section class="space-y-3">
        <h2 class="text-[11px] font-semibold uppercase tracking-[0.18em] text-kt-muted">
            Unread
        </h2>

        @if($unread->isEmpty())
        <div class="kt-card text-xs text-kt-textMuted">
            You have no unread notifications.
        </div>
        @else
        <div class="space-y-2">
            @foreach($unread as $notification)
            @include('notifications.partials.item', ['notification' => $notification])
            @endforeach
        </div>
        @endif
    </section>

    {{-- All notifications --}}
    <section class="space-y-3">
        <h2 class="text-[11px] font-semibold uppercase tracking-[0.18em] text-kt-muted">
            All notifications
        </h2>

        @if($notifications->isEmpty())
        <div class="kt-card text-xs text-kt-textMuted">
            You have no notifications yet.
        </div>
        @else
        <div class="space-y-2">
            @foreach($notifications as $notification)
            @include('notifications.partials.item', ['notification' => $notification])
            @endforeach
        </div>

        <div class="pt-3">
            {{ $notifications->links() }}
        </div>
        @endif
    </section>
</div>
@endsection