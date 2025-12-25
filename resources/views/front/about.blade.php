@extends('layouts.public')

@section('title', 'About — KNEWTODAY')

@section('content')
<main class="flex-1">
    <div class="max-w-5xl mx-auto px-4 py-10 space-y-10">

        {{-- Banner --}}
        <section
            class="border border-kt-border rounded-2xl bg-gradient-to-r from-slate-950 via-kt-card to-slate-950 px-6 py-8 space-y-3">
            <p class="text-[11px] uppercase tracking-[0.22em] text-kt-textMuted">
                About
            </p>
            <h1 class="font-heading text-3xl md:text-4xl tracking-[0.2em] uppercase text-kt-text">
                KNEWTODAY
            </h1>
            <p class="text-sm text-kt-textMuted max-w-2xl">
                Exploring mysteries, untold stories, and the science behind the unknown — through slow,
                careful, documentary-style storytelling.
            </p>
        </section>

        {{-- What KNEWTODAY is --}}
        <section class="grid gap-8 md:grid-cols-2 items-start">
            <div class="space-y-3">
                <h2 class="kt-section-title text-base">
                    What KNEWTODAY is about
                </h2>
                <p class="text-sm text-kt-textMuted">
                    KNEWTODAY is a home for long-form stories on events that refuse to fully close — strange
                    signals, disappearances, unexplained phenomena, and the investigations that follow them.
                </p>
                <p class="text-sm text-kt-textMuted">
                    Each story is written like a documentary episode: clear, paced, and grounded in sources.
                    The goal isn’t to sensationalize, but to understand what actually happened, what we
                    still don’t know, and what the best theories are.
                </p>
            </div>

            <div class="kt-card space-y-3 text-sm text-kt-textMuted">
                <h3 class="text-xs font-semibold text-kt-text uppercase tracking-[0.18em]">
                    How it works
                </h3>
                <ul class="space-y-2 list-disc list-inside">
                    <li><span class="text-kt-text">Pick a mystery</span> — an event, a case, a signal, or a
                        story that still has open questions.</li>
                    <li><span class="text-kt-text">Collect sources</span> — news reports, papers,
                        interviews, timelines, maps, and official records.</li>
                    <li><span class="text-kt-text">Rebuild the story</span> — in clear language, with
                        timestamps, context, and alternative theories.</li>
                    <li><span class="text-kt-text">Leave space for “we don’t know”</span> — because
                        unanswered questions are part of the story.</li>
                </ul>
            </div>
        </section>

        {{-- Approach / style --}}
        <section class="grid gap-8 md:grid-cols-3">
            <div class="kt-card space-y-2 text-sm">
                <h3 class="text-xs font-semibold text-kt-text uppercase tracking-[0.18em]">
                    Slow, not noisy
                </h3>
                <p class="text-kt-textMuted">
                    Stories take time to research and write. There’s no daily “news cycle” to chase — just
                    episodes released when they’re ready.
                </p>
            </div>

            <div class="kt-card space-y-2 text-sm">
                <h3 class="text-xs font-semibold text-kt-text uppercase tracking-[0.18em]">
                    Sources first
                </h3>
                <p class="text-kt-textMuted">
                    Whenever possible, stories are built from primary sources: official documents, statements,
                    and expert analysis — not just recycled rumors.
                </p>
            </div>

            <div class="kt-card space-y-2 text-sm">
                <h3 class="text-xs font-semibold text-kt-text uppercase tracking-[0.18em]">
                    Human & honest
                </h3>
                <p class="text-kt-textMuted">
                    The tone stays calm, curious, and honest about what’s verifiable — and what may always
                    remain uncertain.
                </p>
            </div>
        </section>

        {{-- Who this is for --}}
        <section class="kt-card space-y-4">
            <h2 class="kt-section-title text-base">
                Who KNEWTODAY is for
            </h2>
            <div class="grid gap-6 md:grid-cols-2 text-sm text-kt-textMuted">
                <div class="space-y-2">
                    <p class="text-kt-text">
                        People who like slow, deep dives instead of endless scrolls.
                    </p>
                    <ul class="space-y-1 list-disc list-inside">
                        <li>Curious minds who enjoy “wait, what really happened?” stories.</li>
                        <li>Viewers who love documentary channels and long-form explainers.</li>
                        <li>Readers who prefer one good story over twenty shallow ones.</li>
                    </ul>
                </div>
                <div class="space-y-2">
                    <p class="text-kt-text">
                        Creators, researchers, and late-night rabbit-hole explorers.
                    </p>
                    <ul class="space-y-1 list-disc list-inside">
                        <li>Writers and editors who care about structure and clarity.</li>
                        <li>Artists and video creators looking for well-researched scripts.</li>
                        <li>Anyone who enjoys connecting science, history, and mystery.</li>
                    </ul>
                </div>
            </div>
        </section>

        {{-- Simple “roadmap” / timeline --}}
        <section class="space-y-4">
            <h2 class="kt-section-title text-base">
                The plan moving forward
            </h2>
            <div class="grid gap-4 md:grid-cols-3 text-sm text-kt-textMuted">
                <div class="kt-card space-y-1">
                    <p class="text-[11px] uppercase tracking-[0.18em] text-kt-muted">
                        Phase 1
                    </p>
                    <p class="text-kt-text font-semibold">
                        Core stories
                    </p>
                    <p>
                        Build a library of foundational mysteries — the cases that define the tone and style of
                        KNEWTODAY.
                    </p>
                </div>
                <div class="kt-card space-y-1">
                    <p class="text-[11px] uppercase tracking-[0.18em] text-kt-muted">
                        Phase 2
                    </p>
                    <p class="text-kt-text font-semibold">
                        Deeper research
                    </p>
                    <p>
                        Add timelines, maps, and expert commentary, and connect stories across similar patterns.
                    </p>
                </div>
                <div class="kt-card space-y-1">
                    <p class="text-[11px] uppercase tracking-[0.18em] text-kt-muted">
                        Phase 3
                    </p>
                    <p class="text-kt-text font-semibold">
                        Multi-format
                    </p>
                    <p>
                        Expand into video episodes, visuals, and interactive ways to explore each case.
                    </p>
                </div>
            </div>
        </section>

        {{-- Newsletter --}}
        @include('components.newsletter')

    </div>
</main>
@endsection