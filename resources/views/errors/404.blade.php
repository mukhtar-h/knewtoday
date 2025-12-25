@extends('layouts.public')

@section('title', '404 — Page Not Found')

@section('content')
<main class="flex-1">
    <div class="max-w-4xl mx-auto px-4 py-20 text-center space-y-10">

        {{-- Big Code --}}
        <h1 class="font-heading text-7xl md:text-8xl tracking-[0.25em] text-kt-text opacity-80">
            404
        </h1>

        {{-- Message --}}
        <div class="space-y-3">
            <h2 class="text-xl md:text-2xl font-semibold text-kt-text">
                The mystery deepens...
            </h2>
            <p class="text-sm text-kt-textMuted max-w-md mx-auto leading-relaxed">
                The page you're looking for has vanished —
                like a signal lost in cosmic noise.
                It may have moved, been renamed, or never existed.
            </p>
        </div>

        {{-- Search Bar --}}
        <div class="max-w-md mx-auto">
            <form action="{{ route('front.search') }}" method="GET" class="flex gap-2">
                <input type="search" name="q"
                    placeholder="Search stories…"
                    class="flex-1 px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-sm text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">
                <button class="kt-btn-primary text-[11px] px-4">
                    Search
                </button>
            </form>
        </div>

        {{-- Navigation Links --}}
        <div class="flex flex-wrap justify-center gap-4 text-xs text-kt-textMuted pt-6">
            <a href="{{ route('home') }}" class="kt-btn-outline">Home</a>
            <a href="{{ route('front.posts.index') }}" class="kt-btn-outline">All Stories</a>
            <a href="{{ route('front.categories.index') }}" class="kt-btn-outline">Categories</a>
            <a href="{{ route('front.tags.index') }}" class="kt-btn-outline">Tags</a>
            <a href="{{ route('front.contact') }}" class="kt-btn-outline">Contact</a>
        </div>

        {{-- Graphic --}}
        <div class="pt-12 opacity-40">
            <img src="https://images.pexels.com/photos/2387873/pexels-photo-2387873.jpeg?auto=compress&cs=tinysrgb&w=1200"
                alt="Lost in space"
                class="mx-auto w-full max-w-md rounded-xl border border-kt-border object-cover">
        </div>
    </div>
</main>
@endsection