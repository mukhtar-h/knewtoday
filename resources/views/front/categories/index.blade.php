@extends('layouts.public')

@section('title', 'Categories — KNEWTODAY')

@section('content')
<main class="flex-1">
    <div class="max-w-6xl mx-auto px-4 py-10 space-y-10">

        {{-- Page header --}}
        <div class="space-y-1">
            <h1 class="kt-section-title">Categories</h1>
            <p class="text-sm text-kt-textMuted">
                Explore stories across different themes — mysteries, science, cosmic signals, disappearances, and more.
            </p>
        </div>

        {{-- Categories Grid --}}
        @if($categories->isNotEmpty())
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($categories as $category)
            <a href="{{ route('front.categories.show', $category->slug) }}"
                class="block group border border-kt-border rounded-xl p-6 bg-kt-card hover:border-kt-accent/50 hover:bg-kt-card/80 transition">

                <div class="flex flex-col gap-3">

                    {{-- Title --}}
                    <h2 class="text-lg font-semibold text-kt-text group-hover:text-kt-accent transition">
                        {{ $category->name }}
                    </h2>

                    {{-- Description --}}
                    <p class="text-sm text-kt-textMuted line-clamp-3">
                        {{ $category->description ?? 'Stories filed under '.$category->name.'.' }}
                    </p>

                    {{-- Count --}}
                    <p class="text-xs text-kt-muted mt-1">
                        {{ $category->posts_count }} {{ Str::plural('story', $category->posts_count) }}
                    </p>

                </div>

            </a>
            @endforeach
        </div>
        @else
        {{-- No categories fallback --}}
        <div class="kt-card text-center py-12">
            <h2 class="text-xl font-semibold text-kt-text mb-2">
                No Categories Found
            </h2>
            <p class="text-sm text-kt-textMuted max-w-md mx-auto">
                Once you create categories inside the admin panel, they will appear here.
            </p>

            @auth
            <div class="mt-4">
                <a href="{{ route('admin.categories.create') }}" class="kt-btn-primary text-xs">
                    Create your first category
                </a>
            </div>
            @endauth
        </div>
        @endif

    </div>
</main>
@endsection