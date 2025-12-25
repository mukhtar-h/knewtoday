@extends('layouts.public')

@section('title', 'Tags — KNEWTODAY')

@section('content')
<main class="flex-1">
    <div class="max-w-6xl mx-auto px-4 py-10 space-y-10">

        {{-- Header --}}
        <section class="space-y-2">
            <h1 class="kt-section-title">
                Tags
            </h1>
            <p class="text-sm text-kt-textMuted max-w-2xl">
                Browse stories by topic tags — from #signal and #disappearance to #experiment and beyond.
            </p>
            <p class="text-[11px] text-kt-muted">
                {{ $tags->count() }} {{ \Illuminate\Support\Str::plural('tag', $tags->count()) }}
            </p>
        </section>

        {{-- Tags grid --}}
        @if($tags->isNotEmpty())
        <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($tags as $tag)
            <a href="{{ route('front.tags.show', $tag->slug) }}"
                class="group border border-kt-border rounded-xl px-5 py-4 bg-kt-card hover:border-kt-accent/50 hover:bg-kt-card/80 transition flex flex-col gap-2">
                <div class="flex items-center justify-between gap-3">
                    <h2 class="text-sm font-semibold text-kt-text group-hover:text-kt-accent transition">
                        #{{ $tag->name }}
                    </h2>
                    <span class="text-[11px] text-kt-muted">
                        {{ $tag->posts_count }} {{ \Illuminate\Support\Str::plural('story', $tag->posts_count) }}
                    </span>
                </div>
                <p class="text-xs text-kt-textMuted line-clamp-3">
                    {{ $tag->description ?? 'Stories tagged with #'.$tag->name.'.' }}
                </p>
            </a>
            @endforeach
        </section>
        @else
        <section class="kt-card text-center py-12">
            <h2 class="text-lg font-semibold text-kt-text mb-2">
                No tags yet
            </h2>
            <p class="text-sm text-kt-textMuted max-w-md mx-auto">
                Once you start tagging posts in the admin panel, they will appear here for readers to explore.
            </p>

            @auth
            <div class="mt-4">
                <a href="{{ route('admin.tags.create') }}" class="kt-btn-primary text-[11px]">
                    Create your first tag
                </a>
            </div>
            @endauth
        </section>
        @endif

    </div>
</main>
@endsection