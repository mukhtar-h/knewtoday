        <footer class="border-t border-kt-border/70 text-[11px] text-kt-muted">
            <div
                class="max-w-5xl mx-auto px-4 py-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <span>© {{ date('Y') }} KNEWTODAY.</span>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('front.privacy') }}" class="hover:text-kt-accent">Privacy Policy</a>
                    <a href="{{ route('front.cookies') }}" class="hover:text-kt-accent">Cookie Policy</a>
                    <a href="{{ route('rss') }}" class="hover:text-kt-accent">RSS</a>
                    <a href="{{ route('sitemap') }}" class="hover:text-kt-accent">Sitemap</a>
                </div>
            </div>
        </footer>