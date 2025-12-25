        <header class="fixed inset-x-0 top-0 z-40 w-full border-b border-kt-border/70 bg-kt-bg/90 backdrop-blur">
            <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between gap-3">

                {{-- Left: logo / brand --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <span class="font-heading tracking-[0.25em] text-[11px] md:text-xs text-kt-tex">
                        KNEWTODAY
                    </span>
                </a>

                {{-- Desktop nav --}}
                <nav class="hidden md:flex items-center gap-4 text-[11px] text-kt-textMuted">
                    <a href="{{ route('home') }}"
                        class="hover:text-kt-accent {{ request()->routeIs('home') ? 'text-kt-accent' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('front.posts.index') }}"
                        class="hover:text-kt-accent {{ request()->routeIs('front.posts.*') ? 'text-kt-accent' : '' }}">
                        Stories
                    </a>
                    <a href="{{ route('front.categories.index') }}"
                        class="hover:text-kt-accent {{ request()->routeIs('front.categories.*') ? 'text-kt-accent' : '' }}">
                        Categories
                    </a>
                    <a href="{{ route('front.tags.index') }}"
                        class="hover:text-kt-accent {{ request()->routeIs('front.tags.*') ? 'text-kt-accent' : '' }}">
                        Tags
                    </a>
                    <a href="{{ route('front.about') }}"
                        class="hover:text-kt-accent {{ request()->routeIs('front.about') ? 'text-kt-accent' : '' }}">
                        About
                    </a>
                    <a href="{{ route('front.contact') }}"
                        class="hover:text-kt-accent {{ request()->routeIs('front.contact') ? 'text-kt-accent' : '' }}">
                        Contact
                    </a>

                    {{-- Admin Panel --}}

                    @can('writer')
                    <a href="{{ route('admin.posts.index') }}" class="hover:text-kt-accent">
                        Admin Panel
                    </a>
                    @endcan

                </nav>

                {{-- Right: search + auth + mobile button --}}
                <div class="flex items-center gap-2">

                    {{-- Search icon -> go to search page --}}
                    <a href="{{ route('front.search') }}"
                        class="hidden sm:inline-flex items-center justify-center w-7 h-7 rounded-full border border-kt-border/80 text-[11px] text-kt-textMuted hover:border-kt-accent hover:text-kt-accent transition">
                        🔍
                    </a>

                    {{-- Auth: guest sees Login, auth sees name + logout --}}
                    @guest
                    <a href="{{ route('login') }}"
                        class="hidden sm:inline-flex items-center rounded-full border border-kt-border px-3 py-1 text-[11px] text-kt-textMuted hover:border-kt-accent hover:text-kt-accent transition">
                        Login
                    </a>
                    @endguest

                    @auth

                    @php

                    $unreadCount = auth()->user()->unreadNotifications()->count();
                    $user = auth()->user();
                    $initial = Str::upper(Str::substr($user->name, 0, 1));
                    @endphp

                    {{-- Notifications --}}
                    <a href="{{ route('notifications.index') }}"
                        class="hidden sm:inline-flex items-center gap-1 rounded-full border border-kt-border/80 px-3 py-1 text-[11px] text-kt-textMuted hover:border-kt-accent hover:text-kt-accent transition relative">

                        {{-- Bell Icon --}}
                        <span class="text-[12px] ">🔔</span>

                        {{-- Count Badge --}}
                        @if ($unreadCount > 0)
                        <span
                            class="iline-flex items-center justify-center min-w-[16px] h-[16px] rounded-full text-[9px] text-red-600 px-[3px] ">
                            {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                        </span>
                        @endif
                    </a>

                    {{-- Avatar + name -> Profile --}}
                    <a href="{{ route('profile.edit') }}"
                        class="hidden sm:inline-flex items-center gap-2 rounded-full border border-kt-border px-3 py-1 text-[11px] text-kt-text hover:border-kt-accent hover:text-kt-accent transition">
                        <span
                            class="inline-flex items-center justify-center w-7 h-7 rounded-full border border-kt-border/80 bg-kt-bg text-[11px] font-semibold">
                            {{ $initial }}
                        </span>
                        <span class="max-w-[120px] truncate">
                            {{ Str::limit($user->name, 16) }}
                        </span>
                    </a>

                    {{-- Logout --}}
                    <form method="POST" action="{{ route('logout') }}" class="hidden sm:inline-block">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center rounded-full border border-kt-border px-3 py-1 text-[11px] text-kt-textMuted hover:border-red-500/70 hover:text-red-200 transition">
                            Logout
                        </button>
                    </form>
                    @endauth


                    {{-- Mobile menu button --}}
                    <button type="button"
                        class="md:hidden inline-flex items-center justify-center w-8 h-8 rounded-lg border border-kt-border/80 text-[13px] text-kt-text hover:border-kt-accent hover:text-kt-accent transition"
                        aria-label="Toggle navigation" data-nav-toggle>
                        ☰
                    </button>
                </div>

            </div>

            {{-- Mobile nav menu --}}
            <div class="md:hidden border-t border-kt-border/70 bg-kt-bg/95 hidden" data-nav-menu>
                <div class="max-w-5xl mx-auto px-4 py-3 flex flex-col gap-2 text-[12px] text-kt-textMuted">
                    <a href="{{ route('home') }}"
                        class="py-1 hover:text-kt-accent {{ request()->routeIs('home') ? 'text-kt-accent' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('front.posts.index') }}"
                        class="py-1 hover:text-kt-accent {{ request()->routeIs('front.posts.*') ? 'text-kt-accent' : '' }}">
                        Stories
                    </a>
                    <a href="{{ route('front.categories.index') }}"
                        class="py-1 hover:text-kt-accent {{ request()->routeIs('front.categories.*') ? 'text-kt-accent' : '' }}">
                        Categories
                    </a>
                    <a href="{{ route('front.tags.index') }}"
                        class="py-1 hover:text-kt-accent {{ request()->routeIs('front.tags.*') ? 'text-kt-accent' : '' }}">
                        Tags
                    </a>
                    <a href="{{ route('front.about') }}"
                        class="py-1 hover:text-kt-accent {{ request()->routeIs('front.about') ? 'text-kt-accent' : '' }}">
                        About
                    </a>
                    <a href="{{ route('front.contact') }}"
                        class="py-1 hover:text-kt-accent {{ request()->routeIs('front.contact') ? 'text-kt-accent' : '' }}">
                        Contact
                    </a>
                    <a href="{{ route('front.search') }}"
                        class="py-1 hover:text-kt-accent {{ request()->routeIs('front.search') ? 'text-kt-accent' : '' }}">
                        Search
                    </a>

                    @guest
                    <div class="pt-2 border-t border-kt-border/60 mt-2">
                        <a href="{{ route('login') }}" class="py-1 hover:text-kt-accent">
                            Login
                        </a>
                    </div>
                    @endguest

                    @auth

                    @php
                    $unreadCount = auth()->user()->unreadNotifications()->count();
                    @endphp

                    <div class="pt-2 border-t border-kt-border/60 mt-2 space-y-1">
                        <p class="text-[11px] text-kt-textMuted">
                            Logged in as
                            <span class="text-kt-text font-semibold">
                                {{ \Illuminate\Support\Str::limit(auth()->user()->name, 20) }}
                            </span>
                        </p>

                        {{-- Notifications --}}
                        <a href="{{ route('notifications.index') }}"
                            class="py-1 flex items-center  hover:text-kt-accent">
                            <span>Notifications</span>

                            @if ($unreadCount > 0)
                            <span class="ml-2 min-w-[16px] h-[16px] rounded-full  text-[9px] text-red-600 px-[3px]">
                                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                            </span>
                            @endif
                        </a>

                        {{-- Admin Panel --}}

                        @can('writer')
                        <a href="{{ route('admin.posts.index') }}" class="hover:text-kt-accent">
                            Admin Panel |
                        </a>
                        @endcan

                        <a href="{{ route('dashboard') }}" class="py-1 hover:text-kt-accent">
                            Dashboard |
                        </a>
                        <a href="{{ route('profile.edit') }}" class="py-1 hover:text-kt-accent">
                            Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="pt-1">
                            @csrf
                            <button type="submit" class="py-1 text-left text-red-300 hover:text-red-200">
                                Logout
                            </button>
                        </form>
                    </div>
                    @endauth

                </div>
            </div>
        </header>