@extends('layouts.admin')

@section('title', 'KNEWTODAY — Admin Users')

@section('page_title', 'Users')
@section('page_subtitle', 'Manage roles and access for writers, editors, admins, and more.')

@section('content')

{{-- Flash message --}}
@if(session('status'))
<div class="mb-4 text-xs px-3 py-2 rounded-lg bg-emerald-500/10 border border-emerald-500/50 text-emerald-100">
    {{ session('status') }}
</div>
@endif

<div class="space-y-5">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <h2 class="text-xs font-semibold text-kt-text uppercase tracking-[0.16em]">
            All Users
        </h2>
        <p class="text-[11px] text-kt-muted">
            {{ $users->total() }} total users
        </p>
    </div>

    {{-- Users table --}}
    <section class="kt-card">
        <div class="overflow-x-auto">
            <table class="kt-admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Joined</th>
                        <th>Updated</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    @php
                    $roleValue = $user->role?->value ?? (string) $user->role;
                    $roleLabel = match($roleValue) {
                    'super_admin' => 'Super Admin',
                    'admin' => 'Admin',
                    'editor' => 'Editor',
                    'writer' => 'Writer',
                    'user' => 'User',
                    default => ucfirst($roleValue),
                    };

                    $roleStyles = match($roleValue) {
                    'super_admin' => 'bg-purple-500/10 text-purple-200 border-purple-500/40',
                    'admin' => 'bg-emerald-500/10 text-emerald-300 border-emerald-500/40',
                    'editor' => 'bg-sky-500/10 text-sky-200 border-sky-500/40',
                    'writer' => 'bg-yellow-500/10 text-yellow-100 border-yellow-500/40',
                    'user' => 'bg-slate-500/10 text-slate-200 border-slate-500/40',
                    default => 'bg-slate-500/10 text-slate-200 border-slate-500/40',
                    };
                    @endphp

                    <tr>
                        {{-- Name --}}
                        <td class="text-kt-text text-xs">
                            {{ $user->name }}
                        </td>

                        {{-- Email --}}
                        <td class="text-kt-textMuted text-xs">
                            {{ $user->email }}
                        </td>

                        {{-- Role badge --}}
                        <td>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] border {{ $roleStyles }}">
                                {{ $roleLabel }}
                            </span>
                        </td>

                        {{-- Joined --}}
                        <td class="text-kt-textMuted text-xs whitespace-nowrap">
                            {{ $user->created_at->format('M j, Y') }}
                            <div class="text-[10px] text-kt-muted">
                                {{ $user->created_at->diffForHumans() }}
                            </div>
                        </td>

                        {{-- Updated --}}
                        <td class="text-kt-textMuted text-xs whitespace-nowrap">
                            {{ $user->updated_at->format('M j, Y') }}
                            <div class="text-[10px] text-kt-muted">
                                {{ $user->updated_at->diffForHumans() }}
                            </div>
                        </td>

                        {{-- Actions --}}
                        <td>
                            <div class="flex flex-col items-start gap-1 text-[11px]">

                                {{-- Edit --}}
                                <a href="{{ route('admin.users.edit', $user) }}"
                                    class="text-kt-accent hover:underline">
                                    Edit
                                </a>

                                {{-- Delete (you can later add extra protections) --}}
                                @if(auth()->id() !== $user->id)
                                <form action="{{ route('admin.users.destroy', $user) }}"
                                    method="POST"
                                    onsubmit="return confirm('Delete this user? This cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-kt-textMuted hover:text-red-400">
                                        Delete
                                    </button>
                                </form>
                                @else
                                <span class="text-[10px] text-kt-muted">
                                    You cannot delete yourself.
                                </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-xs text-kt-muted py-6">
                            No users found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="flex items-center justify-between mt-4 text-[11px] text-kt-textMuted">
            <p>
                Showing
                <span class="text-kt-text">{{ $users->firstItem() }}–{{ $users->lastItem() }}</span>
                of
                <span class="text-kt-text">{{ $users->total() }}</span>
                users
            </p>
            {{ $users->links() }}
        </div>
    </section>
</div>
@endsection