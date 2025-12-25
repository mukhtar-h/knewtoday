@extends('layouts.public')

@section('title', ($q ? 'Search: '.$q.' — ' : '').'Search — KNEWTODAY')

@section('content')
<main class="flex-1">
    <div class="max-w-6xl mx-auto px-4 py-10 space-y-10">

        {{-- Header --}}
        <section class="space-y-3">
            <nav class="text-[11px] text-kt-muted flex items-center gap-1">
                <a href="{{ route('home') }}" class="hover:text-kt-accent transition">Home</a>
                <span>/</span>
                <span class="text-kt-text">Search</span>
            </nav>

            <div class="space-y-2">
                <h1 class="kt-section-title">Search</h1>
                <p class="text-sm text-kt-textMuted max-w-2xl">
                    Look across all KNEWTODAY stories — titles, descriptions, categories, and tags.
                </p>

                @if($q)
                <p class="text-[11px] text-kt-muted">
                    Showing results for: <span class="text-kt-text">“{{ $q }}”</span>
                    @if($total)
                    • {{ $total }} {{ \Illuminate\Support\Str::plural('result', $total) }}
                    @else
                    • 0 results
                    @endif
                </p>
                @endif
            </div>
        </section>

        {{-- Search Form --}}
        <section class="kt-card space-y-3">
            <form method="GET" action="{{ route('front.search') }}" class="space-y-3 text-xs">

                <div class="space-y-1">
                    <label class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                        Search Query
                    </label>

                    <input type="search"
                        name="q"
                        value="{{ $q }}"
                        placeholder="Type something like “Wow Signal”, “Disappearance”, “Cosmic Noise”…"
                        class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-sm text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit" class="kt-btn-primary text-[11px]">
                        Search
                    </button>

                    @if($q)
                    <a href="{{ route('front.search') }}" class="kt-btn-outline text-[11px]">
                        Clear
                    </a>
                    @endif
                </div>

                <p class="text-[10px] text-kt-muted">
                    Results show published stories only.
                    For advanced filters, visit the
                    <a href="{{ route('front.posts.index') }}" class="text-kt-accent hover:underline">
                        All Stories
                    </a> page.
                </p>
            </form>
        </section>

        {{-- Before searching --}}
        @if($q === '')
        <section class="kt-card text-sm text-kt-textMuted">
            Start by typing something above — for example:
            <span class="text-kt-text">“Tunguska”</span>,
            <span class="text-kt-text">“disappearance”</span>, or
            <span class="text-kt-text">“unexplained signal”</span>.
        </section>

        {{-- After searching --}}
        @else
        <section class="space-y-4">

            {{-- Results --}}
            @if($total > 0)
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($posts as $post)
                <article class="kt-card overflow-hidden p-0 flex flex-col">

                    <div class="kt-card-image">
                        <img src="{{ $post->thumbnail_path
                                                ?: 'https://images.pexels.com/photos/3888045/pexels-photo-3888045.jpeg?auto=compress&cs=tinysrgb&w=1200' }}"
                            alt="{{ $post->title }}"
                            class="w-full h-full object-cover opacity-90" />
                    </div>

                    <div class="p-4 flex flex-col gap-2 flex-1">

                        {{-- Category + Tag --}}
                        <p class="text-[11px] uppercase tracking-[0.22em] text-kt-textMuted">
                            {{ $post->category?->name ?? 'Uncategorized' }}
                            @php $tag = $post->tags->first(); @endphp
                            @if($tag)
                            • {{ $tag->name }}
                            @endif
                        </p>

                        {{-- Title --}}
                        <h2 class="text-base md:text-lg font-semibold text-kt-text">
                            <a href="{{ route('front.posts.show', $post->slug) }}"
                                class="hover:text-kt-accent transition">
                                {{ $post->title }}
                            </a>
                        </h2>

                        {{-- Excerpt --}}
                        <p class="text-sm text-kt-textMuted">
                            {{ $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->content), 140) }}
                        </p>

                        {{-- Meta --}}
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
                    results
                </p>
                <div>{{ $posts->links() }}</div>
            </div>

            @else
            {{-- No results --}}
            <section class="kt-card text-center py-10 text-sm text-kt-textMuted">
                <h2 class="text-lg font-semibold text-kt-text mb-2">
                    No results found
                </h2>
                <p class="max-w-md mx-auto">
                    Try different keywords, or explore
                    <a href="{{ route('front.posts.index') }}"
                        class="text-kt-accent hover:underline">
                        all stories
                    </a>.
                </p>
            </section>
            @endif
        </section>
        @endif

    </div>
</main>
@endsection