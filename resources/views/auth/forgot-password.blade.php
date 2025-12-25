@extends('layouts.guest')

@section('title', 'Forgot Password — KNEWTODAY')

@section('content')
<div class="kt-card space-y-5">

    {{-- Heading --}}
    <div class="space-y-1 text-center">
        <p class="text-[11px] uppercase tracking-[0.22em] text-kt-textMuted">
            Reset access
        </p>
        <h1 class="text-lg font-semibold text-kt-text">
            Forgot your password?
        </h1>
        <p class="text-[11px] text-kt-muted">
            Enter your email address and we’ll send you a reset link.
        </p>
    </div>

    {{-- Status --}}
    @if (session('status'))
    <div class="text-xs px-3 py-2 rounded-lg bg-emerald-500/10 border border-emerald-500/50 text-emerald-100">
        {{ session('status') }}
    </div>
    @endif

    {{-- Form --}}
    <form method="POST" action="{{ route('password.email') }}" class="space-y-4 text-xs">
        @csrf

        {{-- Email --}}
        <div class="space-y-1">
            <label for="email" class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                Email
            </label>
            <input id="email" type="email" name="email"
                value="{{ old('email') }}"
                required autofocus
                class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">
            @error('email')
            <p class="text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-1">
            <button type="submit" class="kt-btn-primary w-full text-[11px]">
                Send Password Reset Link
            </button>
        </div>

        <p class="text-[11px] text-kt-muted text-center pt-1">
            Remember your password?
            <a href="{{ route('login') }}" class="text-kt-accent hover:underline">
                Go back to login
            </a>
        </p>
    </form>
</div>
@endsection