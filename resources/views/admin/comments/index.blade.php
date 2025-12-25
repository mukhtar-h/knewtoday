@extends('layouts.admin')

@section('title', 'KNEWTODAY — Admin Comments')

@section('page_title', 'Comments')
@section('page_subtitle', 'Review, approve, or hide comments and replies across all stories.')

@section('content')

{{-- Flash message --}}
@if(session('status'))
<div class="mb-4 text-xs px-3 py-2 rounded-lg bg-emerald-500/10 border border-emerald-500/50 text-emerald-100">
    {{ session('status') }}
</div>
@endif

<div class="space-y-5">

    {{-- Filters --}}
    <section class="kt-card">
        <form method="GET"
            action="{{ route('admin.comments.index') }}"
            class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 text-xs">

            {{-- Left: search --}}
            <div class="flex-1 space-y-1">
                <label class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                    Search
                </label>
                <input type="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by comment text, author name, or post title…"
                    class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent" />
            </div>

            {{-- Right: status + post filter --}}
            <div class="flex flex-col sm:flex-row gap-3 md:gap-2 md:w-auto">
                {{-- Status --}}
                <div class="flex flex-col gap-1">
                    <label class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                        Status
                    </label>
                    <select name="status"
                        class="w-full sm:w-40 px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-textMuted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">
                        <option value="">All</option>
                        <option value="approved" @selected(request('status')==='approved' )>Approved</option>
                        <option value="pending" @selected(request('status')==='pending' )>Pending</option>
                        <option value="spam" @selected(request('status')==='spam' )>Spam</option>
                        <option value="hidden" @selected(request('status')==='hidden' )>Hidden</option>
                    </select>
                </div>

                {{-- Post --}}
                <div class="flex flex-col gap-1">
                    <label class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                        Post
                    </label>
                    <select name="post_id"
                        class="w-full sm:w-48 px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-textMuted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">
                        <option value="">All posts</option>
                        @foreach($posts as $post)
                        <option value="{{ $post->id }}" @selected(request('post_id')==$post->id)>
                            {{ $post->title }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </section>

    {{-- Comments table --}}
    <section class="kt-card">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-xs font-semibold text-kt-text uppercase tracking-[0.16em]">
                All Comments
            </h2>
            <p class="text-[11px] text-kt-muted">
                Showing {{ $comments->firstItem() }}–{{ $comments->lastItem() }} of {{ $comments->total() }}
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="kt-admin-table">
                <thead>
                    <tr>
                        <th>Comment</th>
                        <th>On</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th>Posted</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($comments as $comment)
                    @php
                    $status = $comment->status;
                    $statusStyles = match($status) {
                    'approved' => 'bg-emerald-500/10 text-emerald-300 border-emerald-500/30',
                    'pending' => 'bg-yellow-500/10 text-yellow-100 border-yellow-500/40',
                    'spam' => 'bg-red-500/10 text-red-300 border-red-500/40',
                    'hidden' => 'bg-slate-500/10 text-slate-200 border-slate-500/40',
                    default => 'bg-slate-500/10 text-slate-200 border-slate-500/40',
                    };

                    $authorName = $comment->user?->name ?? $comment->guest_name ?? 'Guest';
                    $authorType = $comment->user
                    ? ($comment->user->role->value ?? 'User')
                    : 'Guest';
                    @endphp

                    <tr>
                        {{-- Comment text + reply info --}}
                        <td>
                            <p class="text-kt-text text-xs
                                        @if($status === 'spam') line-through text-red-300/80 @endif
                                        @if($status === 'hidden') opacity-75 @endif
                                    ">
                                “{{ $comment->body }}”
                            </p>

                            @if($comment->parent)
                            <p class="text-[10px] text-kt-muted mt-1">
                                Reply to:
                                {{ $comment->parent->user?->name ?? $comment->parent->guest_name ?? 'Comment #'.$comment->parent->id }}
                            </p>
                            @endif
                        </td>

                        {{-- On (post) --}}
                        <td class="text-kt-textMuted text-xs">
                            {{ $comment->post?->title ?? '—' }}
                            @if($comment->post)
                            <div class="text-[10px] text-kt-muted">
                                /{{ $comment->post->slug }}
                            </div>
                            @endif
                        </td>

                        {{-- Author --}}
                        <td class="text-kt-textMuted text-xs">
                            {{ $authorName }}
                            <div class="text-[10px] text-kt-muted">
                                {{ $authorType }}
                            </div>
                        </td>

                        {{-- Status badge --}}
                        <td>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] border {{ $statusStyles }}">
                                {{ ucfirst($status) }}
                            </span>
                        </td>

                        {{-- Posted --}}
                        <td class="text-kt-textMuted text-xs whitespace-nowrap">
                            {{ $comment->created_at->diffForHumans() }}
                            <div class="text-[10px] text-kt-muted">
                                {{ $comment->created_at->format('M j, Y H:i') }}
                            </div>
                        </td>

                        {{-- Actions --}}
                        <td>
                            <div class="flex flex-col items-start gap-1 text-[11px]">

                                {{-- Approved comment actions --}}
                                @if($status === 'approved')
                                {{-- Reply: for now just placeholder --}}
                                <span class="text-kt-accent cursor-default opacity-60">
                                    Reply (frontend)
                                </span>

                                {{-- Mark as Pending --}}
                                <form method="POST"
                                    action="{{ route('admin.comments.update', $comment) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="pending">
                                    <button class="text-kt-textMuted hover:text-yellow-300">
                                        Mark as Pending
                                    </button>
                                </form>

                                {{-- Hide --}}
                                <form method="POST"
                                    action="{{ route('admin.comments.update', $comment) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="hidden">
                                    <button class="text-kt-textMuted hover:text-red-400">
                                        Hide
                                    </button>
                                </form>
                                @endif

                                {{-- Pending comment actions --}}
                                @if($status === 'pending')
                                {{-- Approve --}}
                                <form method="POST"
                                    action="{{ route('admin.comments.update', $comment) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="approved">
                                    <button class="text-emerald-300 hover:underline">
                                        Approve
                                    </button>
                                </form>

                                {{-- Mark as Spam --}}
                                <form method="POST"
                                    action="{{ route('admin.comments.update', $comment) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="spam">
                                    <button class="text-kt-textMuted hover:text-red-400">
                                        Mark as Spam
                                    </button>
                                </form>

                                {{-- Delete --}}
                                <form method="POST"
                                    action="{{ route('admin.comments.destroy', $comment) }}"
                                    onsubmit="return confirm('Delete this comment?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-kt-textMuted hover:text-red-400">
                                        Delete
                                    </button>
                                </form>
                                @endif

                                {{-- Spam actions --}}
                                @if($status === 'spam')
                                {{-- Restore (back to pending) --}}
                                <form method="POST"
                                    action="{{ route('admin.comments.update', $comment) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="pending">
                                    <button class="text-emerald-300 hover:underline">
                                        Restore
                                    </button>
                                </form>

                                {{-- Delete permanently --}}
                                <form method="POST"
                                    action="{{ route('admin.comments.destroy', $comment) }}"
                                    onsubmit="return confirm('Delete this spam comment permanently?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-kt-textMuted hover:text-red-400">
                                        Delete permanently
                                    </button>
                                </form>
                                @endif

                                {{-- Hidden actions --}}
                                @if($status === 'hidden')
                                {{-- Approve & show --}}
                                <form method="POST"
                                    action="{{ route('admin.comments.update', $comment) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="approved">
                                    <button class="text-emerald-300 hover:underline">
                                        Approve &amp; show
                                    </button>
                                </form>

                                {{-- Delete --}}
                                <form method="POST"
                                    action="{{ route('admin.comments.destroy', $comment) }}"
                                    onsubmit="return confirm('Delete this hidden comment?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-kt-textMuted hover:text-red-400">
                                        Delete
                                    </button>
                                </form>
                                @endif

                            </div>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-xs text-kt-muted py-6">
                            No comments found. Try adjusting filters.
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- Footer --}}
        <div class="flex items-center justify-between mt-4 text-[11px] text-kt-textMuted">
            <p>
                {{ $total }} total comments •
                {{ $approved }} approved •
                {{ $pending }} pending •
                {{ $spam }} spam •
                {{ $hidden }} hidden
            </p>
            <div>
                {{ $comments->links() }}
            </div>
        </div>
    </section>
</div>
@endsection