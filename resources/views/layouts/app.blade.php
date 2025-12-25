<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>
        @yield('title', 'Dashboard — KNEWTODAY')

    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css'])

    @stack('head')

</head>

<body class="min-h-screen bg-kt-bg text-kt-text antialiased">
    <div class="min-h-screen flex flex-col">

        {{-- Top nav (Breeze-style, themed) --}}
        <header class="border-b border-kt-border/70 bg-kt-surface/60 backdrop-blur">
            <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between gap-4">

                {{-- Left: Brand + main links --}}
                <div class="flex items-center gap-6">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <span class="font-heading tracking-[0.25em] text-[11px] text-kt-text">
                            KNEWTODAY
                        </span>
                    </a>
                    {{-- hidden md:flex --}}
                    <nav class="flex items-center gap-4 text-[11px] text-kt-textMuted">
                        <a href="{{ route('dashboard') }}"
                            class="hover:text-kt-accent {{ request()->routeIs('dashboard') ? 'text-kt-accent' : '' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('profile.edit') }}"
                            class="hover:text-kt-accent {{ request()->routeIs('profile.edit') ? 'text-kt-accent' : '' }}">
                            Profile
                        </a>

                        @can('writer')
                        <a href="{{ route('admin.posts.index') }}" class="hover:text-kt-accent">
                            Admin Panel
                        </a>
                        @endcan

                        <a href="{{ route('front.posts.index') }}" class="hover:text-kt-accent">
                            Stories
                        </a>
                    </nav>
                </div>

                {{-- Right: user info + logout --}}
                <div class="flex items-center gap-3 text-[11px] text-kt-textMuted">
                    <span class="hidden sm:inline text-kt-text">
                        {{ auth()->user()->name }}
                    </span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="kt-btn-outline text-[11px] px-3 py-1">
                            Log out
                        </button>
                    </form>
                </div>
            </div>
        </header>

        {{-- Main content --}}
        <main class="flex-1">
            @yield('content')
        </main>

        {{-- Toasts --}}
        @include('partials.toast')

        {{-- FOOTER --}}
        @include('components.footer')

        @stack('scripts')
    </div>
</body>

</html>