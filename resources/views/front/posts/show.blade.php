@extends('layouts.public')

@section('title', $post->title . ' — KNEWTODAY')

@section('meta_description', $post->excerpt)

@section('meta_type', 'article')

@section('meta_image', $post->thumbnail_path ?: asset('img/og-default.jpg'))

@section('canonical', url()->current())
@section('content')
<main class="flex-1">
    <div class="max-w-6xl mx-auto px-4 py-10 space-y-10">

        {{-- Breadcrumb --}}
        <nav class="text-[11px] text-kt-muted flex items-center gap-1">
            <a href="{{ route('home') }}" class="hover:text-kt-accent transition">Home</a>
            <span>/</span>
            <a href="{{ route('front.posts.index') }}" class="hover:text-kt-accent transition">Stories</a>
            @if($post->category)
            <span>/</span>
            <a href="{{ route('front.categories.show', $post->category->slug) }}"
                class="hover:text-kt-accent transition">
                {{ $post->category->name }}
            </a>
            @endif
            <span>/</span>
            <span class="text-kt-text truncate">{{ $post->title }}</span>
        </nav>

        {{-- Header + Meta --}}
        <section class="grid gap-8 lg:grid-cols-[minmax(0,2fr)_minmax(0,1fr)] items-start">
            <div class="space-y-4">
                <p class="font-heading tracking-[0.25em] text-[11px] text-kt-accent uppercase">
                    {{ $post->category?->name ?? 'Story' }}
                </p>
                <h1 class="font-heading text-3xl md:text-4xl lg:text-5xl leading-tight text-kt-text">
                    {{ $post->title }}
                </h1>

                {{-- Meta row --}}
                <div class="flex flex-wrap items-center gap-3 text-[11px] text-kt-muted">
                    <span>
                        By
                        <span class="text-kt-text">
                            {{ $post->author?->name ?? 'KNEWTODAY' }}
                        </span>
                    </span>
                    <span>•</span>
                    <span>
                        {{ optional($post->updated_at)->format('F j, Y') }}
                    </span>
                    <span>•</span>
                    <span>
                        {{ $post->reading_time ?? '—' }} min read
                    </span>
                </div>

                {{-- Tags --}}
                @if($post->tags->isNotEmpty())
                <div class="flex flex-wrap gap-2 pt-1 text-[11px]">
                    @foreach($post->tags as $tag)
                    <a href="{{ route('front.tags.show', $tag->slug ?? $tag->id) }}"
                        class="px-2 py-1 rounded-full border border-kt-border text-kt-textMuted hover:border-kt-accent hover:text-kt-accent transition">
                        #{{ $tag->name }}
                    </a>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Side meta card --}}
            <aside class="kt-card space-y-3 text-xs">
                <p class="text-[11px] uppercase tracking-[0.18em] text-kt-muted">
                    Story Details
                </p>
                <div class="space-y-1 text-kt-textMuted">
                    <p>
                        <span class="text-kt-text">Category:</span>
                        {{ $post->category?->name ?? 'Uncategorized' }}
                    </p>
                    <p>
                        <span class="text-kt-text">Status:</span>
                        {{ $post->status?->value ?? 'Published' }}
                    </p>
                    <p class="break-all">
                        <span class="text-kt-text">Canonical:</span>
                        <a href="{{ route('front.posts.show', $post) }}" class="hover:text-kt-accent transition">
                            {{ route('front.posts.show', $post) }}
                        </a>
                    </p>
                </div>
            </aside>
        </section>

        {{-- Hero image + Content --}}
        <section class="grid gap-8 lg:grid-cols-[minmax(0,2.2fr)_minmax(0,1fr)] items-start">

            {{-- Main article --}}
            <article class="space-y-6">

                {{-- Hero image --}}
                @if ($post->thumbnail_path)

                <div class="rounded-xl overflow-hidden border border-kt-border bg-kt-card mb-4">
                    <img src="{{ asset('storage/'.$post->thumbnail_path) }}"
                        alt="{{ $post->title }}"
                        class="w-full h-full object-cover opacity-90" />
                </div>
                @endif

                {{-- Article body --}}
                <section class="space-y-5 text-[15px] leading-relaxed text-kt-text prose prose-invert max-w-none">

                    @trix($post->content)

                </section>

                {{-- Share section --}}
                <section class="flex flex-wrap items-center justify-between gap-3 border-t border-kt-border/70 pt-4">
                    <p class="text-xs text-kt-textMuted">
                        Share this story:
                    </p>
                    <div class="flex flex-wrap items-center gap-2 text-xs">
                        <button type="button"
                            class="border border-kt-border rounded-full px-3 py-1 text-kt-textMuted hover:border-kt-accent hover:text-kt-accent transition"
                            onclick="navigator.clipboard && navigator.clipboard.writeText('{{ request()->fullUrl() }}')">
                            Copy link
                        </button>
                        <a target="_blank"
                            href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($post->title) }}"
                            class="border border-kt-border rounded-full px-3 py-1 text-kt-textMuted hover:border-kt-accent hover:text-kt-accent transition">
                            Twitter / X
                        </a>
                        <a target="_blank"
                            href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                            class="border border-kt-border rounded-full px-3 py-1 text-kt-textMuted hover:border-kt-accent hover:text-kt-accent transition">
                            Facebook
                        </a>
                    </div>
                </section>

                {{-- Author box --}}
                <section class="border border-kt-border rounded-xl bg-kt-card px-5 py-4 flex gap-4 items-start">
                    <div
                        class="w-12 h-12 rounded-full bg-slate-900 flex items-center justify-center text-sm text-kt-textMuted">
                        @php
                        $authorName = $post->author?->name ?? 'KNEWTODAY';
                        $initials = collect(explode(' ', $authorName))->map(fn($p) => mb_substr($p, 0, 1))->join('');
                        @endphp
                        {{ $initials }}
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm font-semibold text-kt-text">
                            {{ $authorName }}
                        </p>
                        <p class="text-xs text-kt-textMuted">
                            Documentary-style storytelling on mysteries, unexplained events, and the science that tries to
                            catch up.
                        </p>
                    </div>
                </section>

            </article>

            {{-- Right column: related & meta --}}
            <aside class="space-y-6">

                {{-- Related stories --}}
                @if($relatedPosts->isNotEmpty())
                <section class="kt-card space-y-3">
                    <h2 class="text-xs font-semibold text-kt-text uppercase tracking-[0.18em]">
                        Related Stories
                    </h2>
                    <div class="space-y-3 text-sm">
                        @foreach($relatedPosts as $related)
                        <article>
                            <h3 class="text-kt-text text-[13px] font-semibold">
                                <a href="{{ route('front.posts.show', $related->slug) }}"
                                    class="hover:text-kt-accent transition">
                                    {{ $related->title }}
                                </a>
                            </h3>
                            <p class="text-[11px] text-kt-textMuted">
                                {{ $related->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($related->content), 90) }}
                            </p>
                            <p class="text-[10px] text-kt-muted mt-1">
                                {{ optional($related->published_at)->format('M j, Y') }}
                                • {{ $related->reading_time ?? '—' }} min read
                            </p>
                        </article>
                        @endforeach
                    </div>
                </section>
                @endif

            </aside>
        </section>

        {{-- Comments section --}}
        <section id="comments" class="mt-10 space-y-6">
            <h2 class="kt-section-title text-base">
                Comments
            </h2>

            {{-- Top-level comment form --}}
            <div class="kt-card text-xs">
                <h3 class="text-[11px] font-semibold text-kt-text uppercase tracking-[0.18em] mb-2">
                    Leave a comment
                </h3>

                <form method="POST" action="{{ route('front.comment.store', $post) }}" class="space-y-3">
                    @csrf

                    @guest
                    <div class="grid gap-3 sm:grid-cols-2">
                        {{-- Name --}}
                        <div class="space-y-1">
                            <label for="comment_name" class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                                Name
                            </label>
                            <input id="comment_name"
                                type="text"
                                name="guest_name"
                                value="{{ old('guest_name') }}"
                                required
                                class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">
                            @error('guest_name')
                            <p class="text-[11px] text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="space-y-1">
                            <label for="comment_email" class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                                Email
                            </label>
                            <input id="comment_email"
                                type="guest_email"
                                name="guest_email"
                                value="{{ old('guest_email') }}"
                                required
                                class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">
                            @error('guest_email')
                            <p class="text-[11px] text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    @endguest

                    {{-- Comment Body --}}
                    <div class="space-y-1">
                        <label for="comment_body" class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                            Comment
                        </label>
                        <textarea id="comment_body"
                            name="body"
                            rows="4"
                            required
                            class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">{{ old('body') }}</textarea>
                        @error('body')
                        <p class="text-[11px] text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- parent_id is null for top-level comments --}}
                    <input type="hidden" name="parent_id" value="">

                    <div class="flex items-center justify-end">
                        <button type="submit" class="kt-btn-primary text-[11px]">
                            Post comment
                        </button>
                    </div>
                </form>
            </div>

            {{-- Existing comments (only once, via partial) --}}
            <div class="space-y-4">

                @forelse($comments as $comment)

                @include('front.posts.partials.comment', ['comment' => $comment, 'post' => $post])

                @empty

                <p class="text-xs text-kt-textMuted">
                    No comments yet. Be the first to share your thoughts.
                </p>

                @endforelse

            </div>
        </section>


    </div>
</main>
@endsection