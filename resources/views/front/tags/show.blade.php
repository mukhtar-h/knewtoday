@extends('layouts.public')

@section('title', '#'.$tag->name.' — Tags — KNEWTODAY')

@section('meta_description', $tag->description ?: 'Stories tagged with #'.$tag->name.' on KNEWTODAY.')

@section('meta_type', 'website')

@section('canonical', route('front.tags.show', $tag->slug))

@section('content')
<main class="flex-1">
    <div class="max-w-6xl mx-auto px-4 py-10 space-y-10">

        {{-- Breadcrumb + header --}}
        <section class="space-y-3">
            <nav class="text-[11px] text-kt-muted flex items-center gap-1">
                <a href="{{ route('home') }}" class="hover:text-kt-accent transition">Home</a>
                <span>/</span>
                <a href="{{ route('front.tags.index') }}" class="hover:text-kt-accent transition">Tags</a>
                <span>/</span>
                <span class="text-kt-text">#{{ $tag->name }}</span>
            </nav>

            <div class="space-y-2">
                <h1 class="kt-section-title">
                    #{{ $tag->name }}
                </h1>
                <p class="text-sm text-kt-textMuted max-w-2xl">
                    {{ $tag->description ?? 'Stories tagged with #'.$tag->name.'.' }}
                </p>
                <p class="text-[11px] text-kt-muted">
                    {{ $posts->total() }} {{ \Illuminate\Support\Str::plural('story', $posts->total()) }} with this tag
                </p>
            </div>
        </section>

        {{-- Filter bar --}}
        <section
            class="border border-kt-border rounded-xl bg-kt-card px-4 py-4 md:px-5 md:py-4 text-xs flex flex-col gap-4 md:flex-row md:items-end md:justify-between">

            <form method="GET"
                action="{{ route('front.tags.show', $tag->slug) }}"
                class="flex-1 flex flex-col gap-3 sm:flex-row sm:items-end sm:gap-4">

                {{-- Search in this tag --}}
                <div class="flex-1 space-y-1">
                    <label class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                        Search in #{{ $tag->name }}
                    </label>
                    <input type="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search by title, excerpt, or content…"
                        class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">
                </div>

                {{-- Category filter --}}
                <div class="space-y-1">
                    <label class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                        Category
                    </label>
                    <select name="category"
                        class="bg-kt-bg border border-kt-border rounded-lg px-3 py-2 text-xs text-kt-textMuted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">
                        <option value="">All categories</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->slug }}"
                            @selected(request('category')===$category->slug)>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Sort --}}
                <div class="space-y-1">
                    <label class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                        Sort
                    </label>
                    <select name="sort"
                        class="bg-kt-bg border border-kt-border rounded-lg px-3 py-2 text-xs text-kt-textMuted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">
                        <option value="latest" @selected(request('sort', 'latest' )==='latest' )>
                            Latest first
                        </option>
                        <option value="oldest" @selected(request('sort')==='oldest' )>
                            Oldest first
                        </option>
                    </select>
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-2 pt-2 sm:pt-0">
                    <a href="{{ route('front.tags.show', $tag->slug) }}"
                        class="kt-btn-outline text-[11px]">
                        Reset
                    </a>
                    <button type="submit" class="kt-btn-primary text-[11px]">
                        Apply
                    </button>
                </div>
            </form>
        </section>

        {{-- Posts grid --}}
        <section class="space-y-4">
            @if($posts->count())
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($posts as $post)
                <article class="kt-card overflow-hidden p-0 flex flex-col">
                    <div class="kt-card-image">
                        <img src="{{ asset('storage/'.$post->thumbnail_path) }}"
                            alt="{{ $post->title }}"
                            class="w-full h-full object-cover opacity-90" />
                    </div>
                    <div class="p-4 flex flex-col gap-2 flex-1">
                        <p class="text-[11px] uppercase tracking-[0.22em] text-kt-textMuted">
                            {{ $post->category?->name ?? 'Uncategorized' }}
                        </p>
                        <h2 class="text-base md:text-lg font-semibold text-kt-text">
                            <a href="{{ route('front.posts.show', $post->slug) }}"
                                class="hover:text-kt-accent transition">
                                {{ $post->title }}
                            </a>
                        </h2>
                        <p class="text-sm text-kt-textMuted">
                            {{ $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->content), 140) }}
                        </p>
                        <div class="mt-2 flex items-center justify-between text-[11px] text-kt-muted">
                            <span>{{ optional($post->published_at)->format('F j, Y') }}</span>
                            <span>{{ $post->reading_time ?? '—' }} min read</span>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="flex items-center justify-between mt-4 text-[11px] text-kt-textMuted">
                <p>
                    Showing
                    <span class="text-kt-text">{{ $posts->firstItem() }}–{{ $posts->lastItem() }}</span>
                    of
                    <span class="text-kt-text">{{ $posts->total() }}</span>
                    stories
                </p>
                <div>
                    {{ $posts->links() }}
                </div>
            </div>
            @else
            <section class="kt-card text-center py-10">
                <h2 class="text-lg font-semibold text-kt-text mb-2">
                    No stories match your filters
                </h2>
                <p class="text-sm text-kt-textMuted max-w-md mx-auto">
                    Try clearing filters or searching with different keywords.
                </p>
                <div class="mt-4">
                    <a href="{{ route('front.tag.show', $tag->slug) }}"
                        class="kt-btn-primary text-[11px]">
                        Reset filters
                    </a>
                </div>
            </section>
            @endif
        </section>

    </div>
</main>
@endsection