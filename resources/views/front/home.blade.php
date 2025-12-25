@extends('layouts.public')

@section('title', 'Home — '.config('app.name'))

@section('meta_description', 'KNEWTODAY publishes long form, documentary style stories about mysteries, unexplained events, lost expeditions, strange signals, and the science that tries to explain them.')

@section('meta_type', 'website')

@section('content')
<main class="flex-1">
    <div class="max-w-6xl mx-auto px-4 py-10 space-y-12">

        {{-- HERO FEATURED STORY --}}
        @if($heroPost)
        <section class="grid md:grid-cols-2 gap-8 items-stretch">
            <div class="flex flex-col justify-center gap-4">
                <p class="font-heading tracking-[0.25em] text-[11px] text-kt-accent uppercase">
                    Featured Story
                </p>

                <h1 class="font-heading text-3xl md:text-4xl lg:text-5xl leading-tight text-kt-text">
                    {{ $heroPost->title }}
                </h1>

                <p class="text-sm md:text-base text-kt-textMuted max-w-xl">
                    {{ $heroPost->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($heroPost->content), 180) }}
                </p>

                <div class="flex flex-wrap items-center gap-3 text-xs text-kt-textMuted">
                    <span class="kt-chip">
                        {{ $heroPost->category?->name ?? 'Uncategorized' }}
                    </span>
                    <span>
                        • {{ optional($heroPost->updated_at)->format('F j, Y') ?? 'Draft' }}
                        • {{ $heroPost->reading_time ?? '—' }} min read
                    </span>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <a href="{{ route('front.posts.show', $heroPost->slug) }}" class="kt-btn-primary">
                        Read Article
                    </a>
                    <a href="{{ route('front.posts.index') }}"
                        class="text-xs text-kt-textMuted hover:text-kt-accent transition">
                        View all stories →
                    </a>
                </div>
            </div>

            {{-- Hero image --}}
            <div class="relative">
                <div class="aspect-video w-full rounded-xl overflow-hidden border border-kt-border bg-kt-card">
                    <img src="{{ $heroPost->thumbnail_path
                                         ?: 'https://images.pexels.com/photos/5726845/pexels-photo-5726845.jpeg?auto=compress&cs=tinysrgb&w=1200' }}"
                        alt="{{ $heroPost->title }}"
                        class="w-full h-full object-cover opacity-90" />
                </div>
                <div class="absolute inset-0 pointer-events-none rounded-xl ring-1 ring-kt-accent/20"></div>
            </div>
        </section>
        @else
        {{-- Fallback if no posts exist yet --}}
        <section class="kt-card text-center py-12">
            <p class="font-heading tracking-[0.25em] text-[11px] text-kt-accent uppercase mb-3">
                Featured Story
            </p>
            <h1 class="font-heading text-3xl md:text-4xl text-kt-text mb-3">
                No stories published yet
            </h1>
            <p class="text-sm text-kt-textMuted max-w-xl mx-auto">
                Soon we will post stories, and featured stories will land here.
            </p>
            <div class="mt-4">
            </div>
        </section>
        @endif

        {{-- SECONDARY FEATURED STORIES --}}
        @if($featuredPosts->isNotEmpty())
        <section class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="kt-section-title">
                    Featured Files
                </h2>
                <a href="{{ route('front.posts.index', ['featured' => 1]) }}"
                    class="text-xs text-kt-textMuted hover:text-kt-accent transition">
                    See all featured →
                </a>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                @foreach($featuredPosts as $post)
                <article class="kt-card">
                    <p class="text-[11px] uppercase tracking-[0.22em] text-kt-textMuted mb-2">
                        {{ $post->category?->name ?? 'Uncategorized' }}

                    </p>
                    <h3 class="text-lg md:text-xl font-semibold text-kt-text mb-2">
                        <a href="{{ route('front.posts.show', $post->slug) }}"
                            class="hover:text-kt-accent transition">
                            {{ $post->title }}
                        </a>
                    </h3>
                    <p class="text-sm text-kt-textMuted mb-3">
                        {{ $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->content), 140) }}
                    </p>
                    <p class="text-xs text-kt-muted">
                        {{ optional($post->updated_at)->format('F j, Y') }}
                        • {{ $post->reading_time ?? '—' }} min read
                    </p>
                </article>
                @endforeach
            </div>
        </section>
        @endif

        {{-- LATEST STORIES GRID --}}
        @if($latestPosts->isNotEmpty())
        <section class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="kt-section-title">
                    Latest Stories
                </h2>
                <a href="{{ route('front.posts.index') }}"
                    class="text-xs text-kt-textMuted hover:text-kt-accent transition">
                    View all →
                </a>
            </div>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($latestPosts as $post)
                <article class="kt-card overflow-hidden p-0 flex flex-col">
                    <div class="kt-card-image">
                        <img src="{{ $post->thumbnail_path
                                                 ?: 'https://images.pexels.com/photos/3888045/pexels-photo-3888045.jpeg?auto=compress&cs=tinysrgb&w=1200' }}"
                            alt="{{ $post->title }}"
                            class="w-full h-full object-cover opacity-90" />
                    </div>
                    <div class="p-4 flex flex-col gap-2 flex-1">
                        <p class="text-[11px] uppercase tracking-[0.22em] text-kt-textMuted">
                            {{ $post->category?->name ?? 'Uncategorized' }}
                        </p>
                        <h3 class="text-base md:text-lg font-semibold text-kt-text">
                            <a href="{{ route('front.posts.show', $post->slug) }}"
                                class="hover:text-kt-accent transition">
                                {{ $post->title }}
                            </a>
                        </h3>
                        <p class="text-sm text-kt-textMuted">
                            {{ $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->content), 130) }}
                        </p>
                        <div class="mt-2 flex items-center justify-between text-xs text-kt-muted">
                            <span>{{ optional($post->updated_at)->format('F j, Y') }}</span>
                            <span>{{ $post->reading_time ?? '—' }} min read</span>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        </section>
        @endif

        {{-- MOST VIEWED (currently: top recent posts) --}}
        @if($mostViewedPosts->isNotEmpty())
        <section class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="kt-section-title">
                    Most Viewed This Week
                </h2>
                <a href="{{ route('admin.posts.index') }}"
                    class="text-xs text-kt-textMuted hover:text-kt-accent transition">
                    View stats →
                </a>
            </div>

            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                @foreach($mostViewedPosts as $index => $post)
                <article class="kt-card p-4">
                    <p class="text-[11px] uppercase tracking-[0.22em] text-kt-textMuted mb-1">
                        #{{ $index + 1 }}
                        @if($post->category)
                        • {{ $post->category->name }}
                        @endif
                    </p>
                    <h3 class="text-sm font-semibold text-kt-text">
                        <a href="{{ route('front.posts.show', $post->slug) }}"
                            class="hover:text-kt-accent transition">
                            {{ $post->title }}
                        </a>
                    </h3>
                    <p class="mt-2 text-[11px] text-kt-muted">
                        {{ $post->reading_time ?? '—' }} min read
                    </p>
                </article>
                @endforeach
            </div>
        </section>
        @endif

        {{-- NEWSLETTER --}}
        @include('components.newsletter')

    </div>
</main>
@endsection