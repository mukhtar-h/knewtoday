@extends('layouts.guest')

@section('title', 'Register — KNEWTODAY')

@section('content')
<div class="kt-card space-y-5">

    {{-- Heading --}}
    <div class="space-y-1 text-center">
        <p class="text-[11px] uppercase tracking-[0.22em] text-kt-textMuted">
            Create account
        </p>
        <h1 class="text-lg font-semibold text-kt-text">
            Join KNEWTODAY
        </h1>
        <p class="text-[11px] text-kt-muted">
            Create an account to manage stories, drafts, comments, and more.
        </p>
    </div>

    {{-- Form --}}
    <form method="POST" action="{{ route('register') }}" class="space-y-4 text-xs">
        @csrf

        {{-- Name --}}
        <div class="space-y-1">
            <label for="name" class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                Name
            </label>
            <input id="name" type="text" name="name"
                value="{{ old('name') }}"
                required autofocus autocomplete="name"
                class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">
            @error('name')
            <p class="text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div class="space-y-1">
            <label for="email" class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                Email
            </label>
            <input id="email" type="email" name="email"
                value="{{ old('email') }}"
                required autocomplete="email"
                class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">
            @error('email')
            <p class="text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div class="space-y-1">
            <label for="password" class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                Password
            </label>
            <input id="password" type="password" name="password"
                required autocomplete="new-password"
                class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">
            @error('password')
            <p class="text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div class="space-y-1">
            <label for="password_confirmation" class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                Confirm Password
            </label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                required autocomplete="new-password"
                class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">
        </div>

        {{-- Submit --}}
        <div class="pt-1">
            <button type="submit" class="kt-btn-primary w-full text-[11px]">
                Create Account
            </button>
        </div>

        {{-- Login link --}}
        <p class="text-[11px] text-kt-muted text-center pt-1">
            Already have an account?
            <a href="{{ route('login') }}" class="text-kt-accent hover:underline">
                Log in
            </a>
        </p>

        {{-- Privacy Policy Page --}}
        <p class="text-[10px] text-kt-muted text-center pt-3 leading-relaxed">
            By creating an account, you agree to our
            <a href="{{ route('front.privacy') }}" class="text-kt-accent hover:underline">Privacy Policy</a>
            and
            <a href="{{ route('front.cookies') }}" class="text-kt-accent hover:underline">Cookie Policy</a>.
        </p>
    </form>
</div>
@endsection