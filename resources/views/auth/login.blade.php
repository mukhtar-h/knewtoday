@extends('layouts.guest')

@section('title', 'Login — KNEWTODAY')

@section('content')
<div class="kt-card space-y-5">

    {{-- Heading --}}
    <div class="space-y-1 text-center">
        <p class="text-[11px] uppercase tracking-[0.22em] text-kt-textMuted">
            Welcome back
        </p>
        <h1 class="text-lg font-semibold text-kt-text">
            Sign in to your account
        </h1>
        <p class="text-[11px] text-kt-muted">
            Use your KNEWTODAY credentials to access the dashboard and tools.
        </p>
    </div>

    {{-- Status message (e.g. "Password reset link sent") --}}
    @if(session('status'))
    <div class="text-xs px-3 py-2 rounded-lg bg-emerald-500/10 border border-emerald-500/50 text-emerald-100">
        {{ session('status') }}
    </div>
    @endif

    {{-- Form --}}
    <form method="POST" action="{{ route('login') }}" class="space-y-4 text-xs">
        @csrf

        {{-- Email --}}
        <div class="space-y-1">
            <label for="email" class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                Email
            </label>
            <input id="email" type="email" name="email"
                value="{{ old('email') }}"
                required autofocus autocomplete="username"
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
                required autocomplete="current-password"
                class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">
            @error('password')
            <p class="text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember + Forgot --}}
        <div class="flex items-center justify-between text-[11px] text-kt-textMuted">
            <label class="inline-flex items-center gap-2">
                <input type="checkbox" name="remember" class="w-3 h-3 rounded border-kt-border bg-kt-bg">
                <span>Remember me</span>
            </label>

            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}"
                class="text-kt-accent hover:underline">
                Forgot password?
            </a>
            @endif
        </div>

        {{-- Submit --}}
        <div class="pt-1">
            <button type="submit" class="kt-btn-primary w-full text-[11px]">
                Sign In
            </button>
        </div>

        {{-- Register link --}}
        @if (Route::has('register'))
        <p class="text-[11px] text-kt-muted text-center pt-1">
            Don’t have an account?
            <a href="{{ route('register') }}" class="text-kt-accent hover:underline">
                Create one
            </a>
        </p>
        @endif

        <p class="text-[10px] text-kt-muted text-center pt-3 leading-relaxed">
            By signing in, you agree to our
            <a href="{{ route('front.privacy') }}" class="text-kt-accent hover:underline">Privacy Policy</a>
            and
            <a href="{{ route('front.cookies') }}" class="text-kt-accent hover:underline">Cookie Policy</a>.
        </p>
    </form>
</div>
@endsection