<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title>
        @yield('title', 'Admin — KNEWTODAY')

    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    @vite(['resources/css/app.css'])

    @stack('head')

</head>

<body class="min-h-screen bg-kt-bg text-kt-text antialiased">
    <div class="min-h-screen flex">

        {{-- SIDEBAR --}}
        <aside
            class="fixed inset-y-0 left-0 z-40 w-60 border-r border-kt-border/70 bg-kt-surface/90 backdrop-blur
                   hidden md:flex md:flex-col"
            data-admin-sidebar>
            <div class="px-4 py-4 border-b border-kt-border/70 flex items-center justify-between gap-2">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <span class="font-heading tracking-[0.25em] text-[11px] text-kt-text">
                        KNEWTODAY
                    </span>
                </a>
            </div>

            <nav class="flex-1 px-3 py-4 space-y-1 text-[11px] text-kt-textMuted overflow-y-auto">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-2 rounded-lg px-2 py-1.5 hover:bg-kt-bg/60
                      {{ request()->routeIs('dashboard') ? 'bg-kt-bg/80 text-kt-text' : '' }}">
                    <span>🏠</span>
                    <span>Dashboard</span>
                </a>

                <p class="mt-4 mb-1 text-[10px] uppercase tracking-[0.2em] text-kt-muted">
                    Content
                </p>
                <a href="{{ route('admin.posts.index') }}"
                    class="flex items-center gap-2 rounded-lg px-2 py-1.5 hover:bg-kt-bg/60
                      {{ request()->routeIs('admin.posts.*') ? 'bg-kt-bg/80 text-kt-text' : '' }}">
                    <span>📝</span>
                    <span>Posts</span>
                </a>
                <a href="{{ route('admin.categories.index') }}"
                    class="flex items-center gap-2 rounded-lg px-2 py-1.5 hover:bg-kt-bg/60
                      {{ request()->routeIs('admin.categories.*') ? 'bg-kt-bg/80 text-kt-text' : '' }}">
                    <span>📂</span>
                    <span>Categories</span>
                </a>
                <a href="{{ route('admin.tags.index') }}"
                    class="flex items-center gap-2 rounded-lg px-2 py-1.5 hover:bg-kt-bg/60
                      {{ request()->routeIs('admin.tags.*') ? 'bg-kt-bg/80 text-kt-text' : '' }}">
                    <span>#</span>
                    <span>Tags</span>
                </a>

                @can('admin')
                <p class="mt-4 mb-1 text-[10px] uppercase tracking-[0.2em] text-kt-muted">
                    Admin
                </p>

                {{-- Comments --}}
                <a href="{{ route('admin.comments.index') }}"
                    class="flex items-center gap-2 rounded-lg px-2 py-1.5 hover:bg-kt-bg/60
                      {{ request()->routeIs('admin.comments.*') ? 'bg-kt-bg/80 text-kt-text' : '' }}">
                    <span>💬</span>
                    <span>Comments</span>
                </a>

                {{-- Users --}}
                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center gap-2 rounded-lg px-2 py-1.5 hover:bg-kt-bg/60
                            {{ request()->routeIs('admin.users.*') ? 'bg-kt-bg/80 text-kt-text' : '' }}">
                    <span>👥</span>
                    <span>Users</span>
                </a>

                {{-- Contact --}}
                <a href="{{ route('admin.contact_messages.index') }}"
                    class="flex items-center gap-2 rounded-lg px-2 py-1.5 hover:bg-kt-bg/60
                    {{ request()->routeIs('admin.contact_messages.*') ? 'bg-kt-bg/80 text-kt-text' : '' }}">
                    <span>📥</span>
                    <span>Contact messages</span>

                    @if (!empty($newContactMessagesCount) && $newContactMessagesCount > 0)
                    <span
                        class="ml-auto inline-flex items-center justify-center rounded-full
                                    bg-kt-accent/10 text-kt-accent border border-kt-accent/60
                                    text-[10px] min-w-[1.25rem] h-5 px-1">
                        {{ $newContactMessagesCount }}
                    </span>
                    @endif
                </a>

                {{-- Newsletter --}}
                <a href="{{ route('admin.newsletter.subscribers.index') }}"
                    class="flex items-center gap-2 rounded-lg px-2 py-1.5 hover:bg-kt-bg/60
                            {{ request()->routeIs('admin.newsletter.subscribers.*') ? 'bg-kt-bg/80 text-kt-text' : '' }}">
                    <span>📧</span>
                    <span>Newsletter</span>
                </a>
                @endcan
            </nav>

            <div
                class="px-3 py-3 border-t border-kt-border/70 text-[11px] text-kt-muted flex items-center justify-between">
                <span>{{ \Illuminate\Support\Str::limit(auth()->user()->name ?? 'Admin', 18) }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="hover:text-kt-accent">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- OVERLAY for mobile --}}
        <div class="fixed inset-0 z-30 bg-black/40 md:hidden hidden" data-admin-sidebar-overlay></div>

        {{-- MAIN AREA --}}
        <div class="flex-1 flex flex-col md:pl-60">
            {{-- Top bar --}}
            <header class="border-b border-kt-border/70 bg-kt-bg/90 backdrop-blur">
                <div class="px-4 py-3 flex items-center justify-between gap-4 ">
                    <div class="flex items-center gap-2">
                        {{-- Sidebar toggle button (mobile) --}}
                        <button type="button"
                            class="md:hidden inline-flex items-center justify-center w-8 h-8 rounded-lg border border-kt-border/80 text-[13px] text-kt-text hover:border-kt-accent hover:text-kt-accent transition"
                            aria-label="Toggle navigation" data-admin-sidebar-toggle>
                            ☰
                        </button>

                        <span class="text-[11px] uppercase tracking-[0.2em] text-kt-muted">
                            Admin Panel
                        </span>
                    </div>

                    <div class="flex items-center gap-3 text-[11px] text-kt-textMuted">
                        <a href="{{ route('home') }}" class="hover:text-kt-accent">
                            View site
                        </a>
                        <a href="{{ route('notifications.index') }}"
                            class="hover:text-kt-accent flex items-center gap-1">
                            🔔
                            <span>Notifications</span>
                        </a>
                    </div>
                </div>
            </header>

            {{-- Content --}}
            <main class="flex-1 mt-2 px-2">

                @yield('content')

            </main>

            {{-- Toasts --}}
            @include('partials.toast')

        </div>
    </div>

    {{-- Sidebar toggle logic --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.querySelector('[data-admin-sidebar]');
            const overlay = document.querySelector('[data-admin-sidebar-overlay]');
            const toggleButtons = document.querySelectorAll('[data-admin-sidebar-toggle]');

            if (!sidebar) return;

            function openSidebar() {
                sidebar.classList.remove('hidden');
                if (overlay) overlay.classList.remove('hidden');
            }

            function closeSidebar() {
                sidebar.classList.add('hidden');
                if (overlay) overlay.classList.add('hidden');
            }

            toggleButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    if (sidebar.classList.contains('hidden')) {
                        openSidebar();
                    } else {
                        closeSidebar();
                    }
                });
            });

            if (overlay) {
                overlay.addEventListener('click', closeSidebar);
            }
        });
    </script>

    @stack('scripts')
</body>

</html>