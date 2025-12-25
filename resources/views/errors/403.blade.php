@extends('layouts.public')

@section('title', '403 — Access Denied')

@section('content')
<main class="flex-1">
    <div class="max-w-4xl mx-auto px-4 py-20 text-center space-y-10">

        {{-- Big Code --}}
        <h1 class="font-heading text-6xl md:text-7xl tracking-[0.25em] text-kt-text opacity-80">
            403
        </h1>

        {{-- Message --}}
        <div class="space-y-3">
            <h2 class="text-xl md:text-2xl font-semibold text-kt-text">
                You don’t have permission to view this page.
            </h2>
            <p class="text-sm text-kt-textMuted max-w-md mx-auto leading-relaxed">
                This area is restricted and requires elevated privileges.
                If you believe this is a mistake, you can contact the team or try logging in with a different account.
            </p>
        </div>

        {{-- Actions --}}
        <div class="flex flex-wrap justify-center gap-4 text-xs text-kt-textMuted pt-4">
            <a href="{{ url()->previous() }}" class="kt-btn-outline">
                ← Go back
            </a>

            @auth
            <a href="{{ route('dashboard') }}" class="kt-btn-primary">
                Dashboard
            </a>
            @else
            <a href="{{ route('login') }}" class="kt-btn-primary">
                Login
            </a>
            @endauth

            <a href="{{ route('front.contact') }}" class="kt-btn-outline">
                Contact Support
            </a>
        </div>

        {{-- Graphic --}}
        <div class="pt-12 opacity-40">
            <img src="https://images.pexels.com/photos/842711/pexels-photo-842711.jpeg?auto=compress&cs=tinysrgb&w=1200"
                alt="Access denied"
                class="mx-auto w-full max-w-md rounded-xl border border-kt-border object-cover">
        </div>

        {{-- Tiny explanation for devs / logs --}}
        <p class="text-[10px] text-kt-muted pt-6">
            If you're an administrator and expected access, review Gate/Policy rules or assigned user roles.
        </p>
    </div>
</main>
@endsection