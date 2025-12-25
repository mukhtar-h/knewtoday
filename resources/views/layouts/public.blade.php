<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>
        @yield('title', 'KNEWTODAY — Stories')

    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    @php
    // Defaults
    $defaultDescription =
    'Documentary-style stories on mysteries, unexplained events, and the science that tries to explain them — KNEWTODAY.';
    $defaultImage = asset('img/og-default.jpg'); // you can change this later
    $defaultType = 'website';

    $metaDescription = trim($__env->yieldContent('meta_description')) ?: $defaultDescription;
    $metaImage = trim($__env->yieldContent('meta_image')) ?: $defaultImage;
    $metaType = trim($__env->yieldContent('meta_type')) ?: $defaultType;
    $canonical = trim($__env->yieldContent('canonical')) ?: url()->current();
    @endphp

    {{-- Basic SEO --}}
    <meta name="description" content="{{ $metaDescription }}">

    {{-- Open Graph (Facebook, LinkedIn, etc.) --}}
    <meta property="og:title" content="@yield('title', 'KNEWTODAY — Stories')" />
    <meta property="og:description" content="{{ $metaDescription }}" />
    <meta property="og:type" content="{{ $metaType }}" />
    <meta property="og:url" content="{{ $canonical }}" />
    <meta property="og:image" content="{{ $metaImage }}" />

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="@yield('title', 'KNEWTODAY — Stories')" />
    <meta name="twitter:description" content="{{ $metaDescription }}" />
    <meta name="twitter:image" content="{{ $metaImage }}" />

    {{-- Canonical URL --}}
    <link rel="canonical" href="{{ $canonical }}" />

    @vite(['resources/css/app.css'])

    @stack('head')

</head>
{{-- bg-kt-bg/90 --}}

<body class="min-h-screen bg-kt-bg text-kt-text antialiased">
    <div class="min-h-screen flex flex-col">

        {{-- HEADER --}}
        @include('components.public-header')

        {{-- MAIN CONTENT (add top padding to account for fixed header) --}}
        <main class="flex-1 pt-16">

            @yield('content')

        </main>

        {{-- FOOTER --}}
        @include('components.footer')

    </div>

    {{-- Toasts --}}
    @include('partials.toast')

    {{-- Loader --}}
    @include('partials.progress-bar')

    {{-- Simple JS for mobile nav toggle --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggle = document.querySelector('[data-nav-toggle]');
            const menu = document.querySelector('[data-nav-menu]');

            if (!toggle || !menu) return;

            toggle.addEventListener('click', () => {
                menu.classList.toggle('hidden');
            });
        });

        (function() {
            const root = document.getElementById('kt-progress');
            if (!root) return;

            const bar = root.querySelector('.kt-progress-bar');

            let running = false;
            let value = 0;
            let timer = null;

            function render(v) {
                bar.style.width = Math.max(0, Math.min(100, v)) + '%';
            }

            function start() {
                if (running) return;
                running = true;
                value = 0;
                render(value);

                root.classList.add('kt-show', 'kt-active');

                // Simulated progress to 85% (real completion happens on page load)
                timer = setInterval(() => {
                    if (!running) return;
                    const inc = value < 60 ? (Math.random() * 10) : (Math.random() * 3);
                    value = Math.min(85, value + inc);
                    render(value);
                }, 220);
            }

            function done() {
                if (!running) return;
                running = false;

                if (timer) clearInterval(timer);
                timer = null;

                // Finish quickly
                root.classList.remove('kt-active');
                render(100);

                setTimeout(() => {
                    root.classList.remove('kt-show');
                    render(0);
                }, 240);
            }

            // Expose for manual async usage
            window.KTProgress = {
                start,
                done
            };

            // Show on form submits (non-AJAX)
            document.addEventListener('submit', function(e) {
                const form = e.target;
                if (!form || form.hasAttribute('data-no-progress')) return;
                start();
            }, true);

            // Show on internal link navigation
            document.addEventListener('click', function(e) {
                const a = e.target.closest('a');
                if (!a) return;

                // ignore anchors, new tabs, downloads
                const href = a.getAttribute('href') || '';
                if (!href || href.startsWith('#')) return;
                if (a.target === '_blank') return;
                if (a.hasAttribute('download')) return;
                if (a.hasAttribute('data-no-progress')) return;
                if (href.startsWith('mailto:') || href.startsWith('tel:')) return;

                // only same-origin
                try {
                    const url = new URL(href, window.location.origin);
                    if (url.origin !== window.location.origin) return;
                } catch (_) {
                    return;
                }

                start();
            }, true);

            // Always complete on page render / bfcache restore
            window.addEventListener('pageshow', function() {
                done();
            });

            // If you ever do fetch/AJAX manually:
            // KTProgress.start(); ... KTProgress.done();
        })();
    </script>

    @stack('scripts')
</body>

</html>