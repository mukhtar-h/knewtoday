@extends('layouts.app')

@section('title', 'Dashboard — KNEWTODAY')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">
    <div class="kt-card space-y-2">
        <h1 class="kt-section-title text-base">
            Dashboard
        </h1>
        <p class="text-sm text-kt-textMuted">
            You’re logged in as
            <span class="text-kt-text font-semibold">{{ auth()->user()->name }}</span>.
        </p>

        <p class="text-[11px] text-kt-muted pt-1">
            In the future, this page can show your activity, saved drafts, or quick links.
            For now, you can manage your account details on the
            <a href="{{ route('profile.edit') }}" class="text-kt-accent hover:underline">
                Profile page
            </a>.
        </p>
    </div>
</div>
@endsection