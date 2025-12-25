@extends('layouts.admin')

@section('title', 'KNEWTODAY — Edit User')

@section('page_title', 'Edit User')
@section('page_subtitle', 'Update profile details and role for this account.')

@section('content')

@if(session('status'))
<div class="mb-4 text-xs px-3 py-2 rounded-lg bg-emerald-500/10 border border-emerald-500/50 text-emerald-100">
    {{ session('status') }}
</div>
@endif

<form method="POST"
    action="{{ route('admin.users.update', $user) }}"
    class="space-y-4 max-w-xl">
    @csrf
    @method('PUT')

    {{-- Name --}}
    <div class="kt-card space-y-3">
        <div class="space-y-1 text-xs">
            <label class="text-[11px] uppercase tracking-[0.18em] text-kt-textMuted">
                Name
            </label>
            <input type="text" name="name"
                value="{{ old('name', $user->name) }}"
                class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-sm text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent" />
            @error('name')
            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div class="space-y-1 text-xs">
            <label class="text-[11px] uppercase tracking-[0.18em] text-kt-textMuted">
                Email
            </label>
            <input type="email" name="email"
                value="{{ old('email', $user->email) }}"
                class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-sm text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent" />
            @error('email')
            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Role --}}
        <div class="space-y-1 text-xs">
            <label class="text-[11px] uppercase tracking-[0.18em] text-kt-textMuted">
                Role
            </label>
            <select name="role"
                class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-text focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">
                @foreach($roles as $role)
                <option value="{{ $role }}"
                    @selected(old('role', $user->role->value ?? $user->role) === $role)>
                    {{ ucwords(str_replace('_', ' ', $role)) }}
                </option>
                @endforeach
            </select>
            <p class="text-[10px] text-kt-muted">
                Super Admin has full control. Admin can manage content & users. Editor reviews posts. Writer only manages their own posts. User is frontend-only.
            </p>
            @error('role')
            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Meta / info --}}
        <div class="pt-2 text-[10px] text-kt-muted">
            <p>
                Joined: <span class="text-kt-text">{{ $user->created_at->format('M j, Y H:i') }}</span>
                • Last updated: <span class="text-kt-text">{{ $user->updated_at->diffForHumans() }}</span>
            </p>
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-2 pt-3">
            <button type="submit" class="kt-btn-primary text-[11px]">
                Save Changes
            </button>

            <a href="{{ route('admin.users.index') }}"
                class="kt-btn-outline text-[11px]">
                Back to Users
            </a>
        </div>
    </div>
</form>
@endsection