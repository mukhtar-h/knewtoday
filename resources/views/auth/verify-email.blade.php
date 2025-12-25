@extends('layouts.guest')

@section('title', 'Verify Email — KNEWTODAY')

@section('content')
<div class="kt-card space-y-5">

    {{-- Heading --}}
    <div class="space-y-1 text-center">
        <p class="text-[11px] uppercase tracking-[0.22em] text-kt-textMuted">
            Verify email
        </p>
        <h1 class="text-lg font-semibold text-kt-text">
            Confirm your email address
        </h1>
        <p class="text-[11px] text-kt-muted">
            Before accessing the dashboard, please verify your email using the link we just sent.
        </p>
    </div>

    {{-- Status --}}
    @if (session('status') == 'verification-link-sent')
    <div class="text-xs px-3 py-2 rounded-lg bg-emerald-500/10 border border-emerald-500/50 text-emerald-100">
        A new verification link has been sent to the email address you provided.
    </div>
    @endif

    {{-- Actions --}}
    <div class="space-y-3 text-xs">
        <form method="POST" action="{{ route('verification.send') }}" class="space-y-3">
            @csrf
            <button type="submit" class="kt-btn-primary w-full text-[11px]">
                Resend Verification Email
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="kt-btn-outline w-full text-[11px]">
                Log Out
            </button>
        </form>
    </div>
</div>
@endsection