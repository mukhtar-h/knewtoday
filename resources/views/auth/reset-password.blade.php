@extends('layouts.guest')

@section('title', 'Reset Password — KNEWTODAY')

@section('content')
<div class="kt-card space-y-5">

    {{-- Heading --}}
    <div class="space-y-1 text-center">
        <p class="text-[11px] uppercase tracking-[0.22em] text-kt-textMuted">
            Reset password
        </p>
        <h1 class="text-lg font-semibold text-kt-text">
            Choose a new password
        </h1>
        <p class="text-[11px] text-kt-muted">
            Enter your email and your new password below.
        </p>
    </div>

    {{-- Form --}}
    <form method="POST" action="{{ route('password.update') }}" class="space-y-4 text-xs">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        {{-- Email --}}
        <div class="space-y-1">
            <label for="email" class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                Email
            </label>
            <input id="email" type="email" name="email"
                value="{{ old('email', $request->email) }}"
                required autocomplete="email"
                class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">
            @error('email')
            <p class="text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div class="space-y-1">
            <label for="password" class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                New Password
            </label>
            <input id="password" type="password" name="password"
                required autocomplete="new-password"
                class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">
            @error('password')
            <p class="text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm --}}
        <div class="space-y-1">
            <label for="password_confirmation" class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                Confirm Password
            </label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                required autocomplete="new-password"
                class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">
        </div>

        <div class="pt-1">
            <button type="submit" class="kt-btn-primary w-full text-[11px]">
                Update Password
            </button>
        </div>
    </form>
</div>
@endsection