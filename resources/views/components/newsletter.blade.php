<section
    class="border border-kt-border rounded-2xl bg-kt-card px-6 py-6 md:py-8 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
    <div class="space-y-2 max-w-lg">
        <h2 class="kt-section-title text-base">
            Stay Updated
        </h2>
        <p class="text-sm text-kt-textMuted">
            Get the latest mysteries, investigations, and science-backed theories from KNEWTODAY delivered straight to your inbox. No spam — just stories.
        </p>
    </div>
    <form method="POST"
        action="{{ route('newsletter.subscribe') }}"
        class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
        @csrf
        <input type="email"
            name="email"
            value="{{ old('email') }}"
            placeholder="you@example.com"
            required
            class="w-full sm:w-64 px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-sm text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent" />

        @error('email')
        <p class="mt-1 text-[11px] text-red-400">{{ $message }}</p>
        @enderror

        <button type="submit" class="kt-btn-primary">
            Subscribe
        </button>
    </form>
</section>