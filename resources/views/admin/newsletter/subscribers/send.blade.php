@extends('layouts.admin')

@section('title', 'Send Newsletter — Admin')

@section('content')
    <div class="max-w-3xl mx-auto px-4 py-6 space-y-6">
        <div class="flex items-center justify-between gap-3">
            <h1 class="kt-section-title text-base">
                Send newsletter
            </h1>
        </div>

        <div class="kt-card text-xs space-y-4">
            <form method="POST" action="{{ route('admin.newsletter.send.store') }}" class="space-y-4">
                @csrf

                <div class="space-y-1">
                    <label for="subject" class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                        Subject
                    </label>
                    <input id="subject" type="text" name="subject" value="{{ old('subject') }}" required
                        class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">
                    @error('subject')
                        <p class="text-[11px] text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label for="content" class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                        Content
                    </label>
                    <textarea id="content" name="content" rows="8" required
                        class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">{{ old('content') }}</textarea>
                    <p class="text-[10px] text-kt-muted mt-1">
                        You can write plain text. Basic line breaks will be preserved.
                    </p>
                    @error('content')
                        <p class="text-[11px] text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-2">
                    <button type="submit" class="kt-btn-primary text-[11px]">
                        Send newsletter
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
