<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>
        @yield('title', 'KNEWTODAY — Auth')

    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css'])

    @stack('head')

</head>

<body class="min-h-screen bg-kt-bg text-kt-text antialiased">
    <div class="min-h-screen flex flex-col">

        {{-- Top bar with logo + link back to site --}}
        <header class="border-b border-kt-border/70">
            <div class="max-w-4xl mx-auto px-4 py-4 flex items-center justify-between gap-4">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <span class="font-heading tracking-[0.25em] text-xs md:text-sm text-kt-text">
                        KNEWTODAY
                    </span>
                </a>
                <a href="{{ route('front.posts.index') }}"
                    class="text-[11px] text-kt-textMuted hover:text-kt-accent transition">
                    ← Back to stories
                </a>
            </div>
        </header>

        {{-- Main auth container --}}
        <main class="flex-1 flex items-center justify-center px-4 py-10">
            <div class="w-full max-w-md">
                @yield('content')

            </div>
        </main>

        {{-- Toast --}}
        @include('partials.toast')

        {{-- FOOTER --}}
        @include('components.footer')

        @stack('scripts')

    </div>
</body>

</html>