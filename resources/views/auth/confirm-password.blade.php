@extends('layouts.guest')

@section('title', 'Confirm Password — KNEWTODAY')

@section('content')
<div class="kt-card space-y-5">

    {{-- Heading --}}
    <div class="space-y-1 text-center">
        <p class="text-[11px] uppercase tracking-[0.22em] text-kt-textMuted">
            Security check
        </p>
        <h1 class="text-lg font-semibold text-kt-text">
            Confirm your password
        </h1>
        <p class="text-[11px] text-kt-muted">
            For your security, please confirm your password before continuing.
        </p>
    </div>

    {{-- Form --}}
    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4 text-xs">
        @csrf

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

        <div class="pt-1">
            <button type="submit" class="kt-btn-primary w-full text-[11px]">
                Confirm
            </button>
        </div>
    </form>
</div>
@endsection