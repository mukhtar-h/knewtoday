@extends('layouts.public')

@section('title', '500 — Something Went Wrong')

@section('content')
<main class="flex-1">
    <div class="max-w-4xl mx-auto px-4 py-20 text-center space-y-10">

        {{-- Big Code --}}
        <h1 class="font-heading text-6xl md:text-7xl tracking-[0.25em] text-kt-text opacity-80">
            500
        </h1>

        {{-- Message --}}
        <div class="space-y-3">
            <h2 class="text-xl md:text-2xl font-semibold text-kt-text">
                Something strange happened.
            </h2>
            <p class="text-sm text-kt-textMuted max-w-md mx-auto leading-relaxed">
                The story you requested triggered an unexpected error.
                It might be a temporary glitch, a broken query, or a bug behind the scenes.
            </p>
            <p class="text-[11px] text-kt-muted">
                If this keeps happening, you can let us know so we can investigate.
            </p>
        </div>

        {{-- Actions --}}
        <div class="flex flex-wrap justify-center gap-4 text-xs text-kt-textMuted pt-4">
            <a href="{{ url()->previous() }}" class="kt-btn-outline">
                ← Go back
            </a>
            <a href="{{ route('home') }}" class="kt-btn-primary">
                Go to Home
            </a>
            <a href="{{ route('front.contact') }}" class="kt-btn-outline">
                Report this issue
            </a>
        </div>

        {{-- Hint for users --}}
        <div class="pt-6 text-[11px] text-kt-muted max-w-md mx-auto">
            <p>
                If you contact us about this error, mentioning what you were trying to do
                (page URL, button clicked, etc.) helps a lot.
            </p>
        </div>

        {{-- Subtle graphic --}}
        <div class="pt-10 opacity-40">
            <img src="https://images.pexels.com/photos/3404200/pexels-photo-3404200.jpeg?auto=compress&cs=tinysrgb&w=1200"
                alt="Glitchy monitor"
                class="mx-auto w-full max-w-md rounded-xl border border-kt-border object-cover">
        </div>
    </div>
</main>
@endsection