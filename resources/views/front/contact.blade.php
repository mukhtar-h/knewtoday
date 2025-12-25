@extends('layouts.public')

@section('title', 'Contact — KNEWTODAY')

@section('content')
<main class="flex-1">
    <div class="max-w-4xl mx-auto px-4 py-10 space-y-10">

        {{-- Header --}}
        <section class="space-y-2">
            <h1 class="kt-section-title">
                Contact
            </h1>
            <p class="text-sm text-kt-textMuted max-w-2xl">
                Have a story idea, correction, or collaboration in mind? Use the form below to get in touch.
            </p>
        </section>

        {{-- Flash message --}}
        @if(session('status'))
        <div class="text-xs px-3 py-2 rounded-lg bg-emerald-500/10 border border-emerald-500/50 text-emerald-100">
            {{ session('status') }}
        </div>
        @endif

        {{-- Contact form --}}
        <section class="kt-card space-y-4">
            <h2 class="text-xs font-semibold text-kt-text uppercase tracking-[0.18em]">
                Send a message
            </h2>

            <form method="POST" action="{{ route('front.contact.submit') }}" class="space-y-4">
                @csrf

                {{-- Honeypot (hidden) --}}
                <div class="hidden">
                    <label for="website">Website</label>
                    <input id="website" type="text" name="website" autocomplete="off">
                </div>

                <div class="grid gap-3 sm:grid-cols-2 text-xs">
                    <div class="space-y-1">
                        <label for="name" class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                            Name
                        </label>
                        <input id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">
                        @error('name')
                        <p class="text-[11px] text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label for="email" class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                            Email
                        </label>
                        <input id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">
                        @error('email')
                        <p class="text-[11px] text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="space-y-1 text-xs">
                    <label for="subject" class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                        Subject (optional)
                    </label>
                    <input id="subject"
                        type="text"
                        name="subject"
                        value="{{ old('subject') }}"
                        class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">
                    @error('subject')
                    <p class="text-[11px] text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1 text-xs">
                    <label for="message" class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                        Message
                    </label>
                    <textarea id="message"
                        name="message"
                        rows="5"
                        required
                        class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">{{ old('message') }}</textarea>
                    @error('message')
                    <p class="text-[11px] text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit" class="kt-btn-primary text-[11px]">
                        Send message
                    </button>
                </div>
            </form>

        </section>

        {{-- Extra info --}}
        <section class="text-xs text-kt-textMuted space-y-1">
            <p>
                For general questions about the project, collaborations, or feedback on how stories are told,
                this form is the best place to start.
            </p>
            <p>
                You can also keep up with new episodes through the newsletter and YouTube channel.
            </p>
        </section>

    </div>
</main>
@endsection