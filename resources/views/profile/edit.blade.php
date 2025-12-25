@extends('layouts.app')

@section('title', 'Account Settings')

@section('content')
    <div class="max-w-3xl mx-auto px-4 py-6 space-y-8">

        {{-- Header --}}
        <section class="space-y-1">
            <h1 class="kt-section-title text-base">
                Account Settings
            </h1>
            <p class="text-xs text-kt-textMuted">
                Manage your profile information, email address, password, and account visibility.
            </p>
        </section>

        {{-- Profile Information --}}
        <section class="kt-card space-y-4 text-xs">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-xs font-semibold text-kt-text uppercase tracking-[0.18em]">
                        Profile Information
                    </h2>
                    <p class="text-[11px] text-kt-textMuted mt-1">
                        Update your name and email address.
                    </p>
                </div>
            </div>

            {{-- Email verification notice --}}
            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                <div
                    class="text-[11px] px-3 py-2 rounded-lg bg-amber-500/10 border border-amber-500/50 text-amber-100 space-y-1">
                    <p>
                        Your email address is unverified.
                    </p>
                    <form method="POST" action="{{ route('verification.send') }}" class="inline-block mt-1">
                        @csrf
                        <button type="submit" class="underline hover:text-white">
                            Click here to resend the verification email.
                        </button>
                    </form>
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                @csrf
                @method('patch')

                {{-- Name --}}
                <div class="space-y-1">
                    <label for="name" class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                        Name
                    </label>
                    <input id="name" name="name" type="text" value="{{ old('name', auth()->user()->name) }}"
                        required autofocus autocomplete="name"
                        class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent" />
                    @error('name')
                        <p class="text-[11px] text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="space-y-1">
                    <label for="email" class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                        Email
                    </label>
                    <input id="email" name="email" type="email" value="{{ old('email', auth()->user()->email) }}"
                        required autocomplete="email"
                        class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent" />
                    @error('email')
                        <p class="text-[11px] text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="submit" class="kt-btn-primary text-[11px]">
                        Save Changes
                    </button>
                </div>
            </form>
        </section>

        {{-- Update Password --}}
        <section class="kt-card space-y-4 text-xs">
            <div class="space-y-1">
                <h2 class="text-xs font-semibold text-kt-text uppercase tracking-[0.18em]">
                    Update Password
                </h2>
                <p class="text-[11px] text-kt-textMuted">
                    Use a strong password you don’t reuse on other sites.
                </p>
            </div>

            <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                @csrf
                @method('put')

                {{-- Current Password --}}
                <div class="space-y-1">
                    <label for="current_password" class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                        Current Password
                    </label>
                    <input id="current_password" name="current_password" type="password" required
                        autocomplete="current-password"
                        class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent" />
                    @error('current_password')
                        <p class="text-[11px] text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- New Password --}}
                <div class="space-y-1">
                    <label for="password" class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                        New Password
                    </label>
                    <input id="password" name="password" type="password" required autocomplete="new-password"
                        class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent" />
                    @error('password')
                        <p class="text-[11px] text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="space-y-1">
                    <label for="password_confirmation" class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                        Confirm New Password
                    </label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        autocomplete="new-password"
                        class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent" />
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="submit" class="kt-btn-primary text-[11px]">
                        Update Password
                    </button>
                </div>
            </form>
        </section>

        {{-- Delete Account --}}
        <section class="kt-card space-y-4 text-xs border-red-500/40">
            <div class="space-y-1">
                <h2 class="text-xs font-semibold text-red-300 uppercase tracking-[0.18em]">
                    Delete Account
                </h2>
                <p class="text-[11px] text-kt-textMuted">
                    Once your account is deleted, all of its data may be permanently removed. This action cannot be undone.
                </p>
            </div>

            <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-3"
                onsubmit="return confirm('Are you sure you want to delete your account? This cannot be undone.');">
                @csrf
                @method('delete')

                {{-- Confirm with password (Breeze usually requires this via controller validation) --}}
                <div class="space-y-1">
                    <label for="delete_password" class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                        Confirm with Password
                    </label>
                    <input id="delete_password" name="password" type="password" required autocomplete="current-password"
                        class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-red-500/60 text-xs text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-400" />
                    @error('password')
                        <p class="text-[11px] text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between gap-4 pt-2">
                    <p class="text-[11px] text-kt-muted">
                        This will log you out and remove access to your account.
                    </p>
                    <button type="submit"
                        class="px-3 py-1.5 rounded-lg border border-red-500/60 bg-red-500/10 text-[11px] text-red-200 hover:bg-red-500/20">
                        Delete Account
                    </button>
                </div>
            </form>
        </section>

    </div>
@endsection
