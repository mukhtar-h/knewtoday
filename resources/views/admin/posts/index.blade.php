@extends('layouts.admin')

@section('title', 'KNEWTODAY — Admin Posts')

@section('page_title', 'Posts')
@section('page_subtitle', 'Write, review, and manage stories for KNEWTODAY.')

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
        <form method="GET" action="{{ route('admin.posts.index') }}"
            class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 text-xs">

            {{-- Search --}}
            <div class="flex-1 space-y-1">
                <label class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                    Search
                </label>
                <input type="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by title, slug, or author…"
                    class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent" />
            </div>

            {{-- Status filter --}}
            <div class="flex flex-col gap-1 md:w-40">
                <label class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                    Status
                </label>
                <select name="status"
                    class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-textMuted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">
                    <option value="">All statuses</option>
                    @foreach($statuses as $status)
                    <option value="{{ $status }}"
                        @selected(request('status')===$status)>
                        {{ ucwords(str_replace('_', ' ', $status)) }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Category filter --}}
            <div class="flex flex-col gap-1 md:w-48">
                <label class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                    Category
                </label>
                <select name="category_id"
                    class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-textMuted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">
                    <option value="">All categories</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        @selected(request('category_id')==$category->id)>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Buttons --}}
            <div class="flex items-center gap-2 md:justify-end">
                <a href="{{ route('admin.posts.index') }}"
                    class="kt-btn-outline text-[11px]">
                    Reset
                </a>

                @can('create', App\Models\Post::class)
                <a href="{{ route('admin.posts.create') }}"
                    class="kt-btn-primary text-[11px]">
                    + New Post
                </a>
                @endcan
            </div>
        </form>
    </section>

    {{-- Posts table --}}
    <section class="kt-card">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-xs font-semibold text-kt-text uppercase tracking-[0.16em]">
                All Posts
            </h2>
            <p class="text-[11px] text-kt-muted">
                {{ $posts->total() }} total posts
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="kt-admin-table">
                <thead>
                    <tr class="text-[11px] text-kt-muted border-b border-kt-border/70">
                        <th class="py-2 px-3 text-left">Title</th>
                        <th class="py-2 px-3 text-left">Category</th>
                        <th class="py-2 px-3 text-left">Author</th>
                        <th class="py-2 px-3 text-left">Status</th>
                        <th class="py-2 px-3 text-left">Featured</th>
                        <th class="py-2 px-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                    <tr>
                        {{-- Title + slug --}}
                        <td>
                            <p class="text-kt-text text-xs">
                                {{ $post->title }}
                                @if($post->is_featured)
                                <span class="ml-1 text-[10px] px-1.5 py-0.5 rounded-full bg-kt-highlight/10 text-kt-highlight border border-kt-highlight/40">
                                    Featured
                                </span>
                                @endif
                            </p>
                            <p class="text-[10px] text-kt-muted">
                                /stories/{{ $post->slug }}
                            </p>
                        </td>

                        {{-- Category --}}
                        <td class="text-kt-textMuted text-xs">
                            {{ $post->category?->name ?? '—' }}
                        </td>

                        {{-- Author --}}
                        <td class="text-kt-textMuted text-xs">
                            {{ $post->author?->name ?? 'Unknown' }}
                        </td>

                        {{-- Post Status --}}
                        <td class="py-2 px-3 align-top text-xs">
                            @can('changeStatus', $post)

                            <form method="POST" action="{{ route('admin.posts.updateStatus', $post) }}" class="flex items-center gap-2">

                                @csrf
                                @method('PATCH')

                                <select name="status"
                                    class="px-2 py-1 rounded-md bg-kt-bg border border-kt-border text-[11px] text-kt-textMuted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">
                                    <option value="draft" @selected(trim($post->status->value) === "draft")>Draft</option>
                                    <option value="under_review" @selected(trim($post->status->value) === "under_review")>Under review</option>
                                    <option value="published" @selected(trim($post->status->value) === "published")>Published</option>
                                    <option value="archived" @selected(trim($post->status->value) === "archived")>Archived</option>
                                </select>

                                <button type="submit"
                                    class="px-2 py-1 rounded-md border border-kt-border text-[10px] text-kt-textMuted hover:border-kt-accent hover:text-kt-accent">
                                    Update
                                </button>
                            </form>

                            @else

                            {{-- Read-only badge for non-admins --}}

                            @php
                            $status = $post->status->value;
                            $label = ucfirst(str_replace('_', ' ', $status));
                            $class = match ($status) {
                            'published' => 'bg-emerald-500/10 text-emerald-300 border-emerald-500/40',
                            'under_review' => 'bg-amber-500/10 text-amber-300 border-amber-500/40',
                            'archived' => 'bg-slate-500/10 text-slate-300 border-slate-500/40',
                            default => 'bg-kt-bg/60 text-kt-textMuted border-kt-border/80',
                            };
                            @endphp

                            <span class="inline-flex items-center rounded-full border px-2 py-0.5 text-[10px] {{ $class }}">
                                {{ $label }}
                            </span>
                            @endcan
                        </td>
                        
                        {{-- Read-only badge for non-admins --}}
                        <td class="py-2 px-3 align-top text-xs">
                            @can('changeStatus', $post)
                                <form method="POST"
                                    action="{{ route('admin.posts.updateFeatured', $post) }}"
                                    class="inline-flex items-center gap-2"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <input type="hidden" name="is_featured" value="0">

                                    <label class="inline-flex items-center gap-1 cursor-pointer text-[11px] text-kt-textMuted">
                                        <input type="checkbox"
                                            name="is_featured"
                                            value="1"
                                            @checked($post->is_featured)
                                            class="h-3.5 w-3.5 rounded border-kt-border bg-kt-bg text-kt-accent focus:ring-kt-accent/60 focus:ring-1">
                                        <span>Featured</span>
                                    </label>

                                    <button type="submit"
                                            class="px-2 py-1 rounded-md border border-kt-border text-[10px] text-kt-textMuted hover:border-kt-accent hover:text-kt-accent">
                                        Save
                                    </button>
                                </form>
                            @else
                                <span class="text-[10px] text-kt-muted">
                                    {{ $post->is_featured ? 'Yes' : 'No' }}
                                </span>
                            @endcan
                        </td>                               


                        {{-- Actions --}}
                        <td>
                            <div class="flex flex-col items-start gap-1 text-[11px]">
                                @can('update', $post)
                                <a href="{{ route('admin.posts.edit', $post) }}"
                                    class="text-kt-accent hover:underline">
                                    Edit
                                </a>
                                @endcan

                                {{-- Optional: link to public post if you already have a route --}}
                                {{-- <a href="{{ route('post.show', $post->slug) }}" target="_blank" class="text-kt-textMuted hover:text-kt-accent">
                                View
                                </a> --}}

                                @can('delete', $post)
                                <form action="{{ route('admin.posts.destroy', $post) }}"
                                    method="POST"
                                    onsubmit="return confirm('Delete this post?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-kt-textMuted hover:text-red-400">
                                        Delete
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-xs text-kt-muted py-6">
                            No posts found. Try adjusting filters or create a new post.
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
                <span class="text-kt-text">
                    {{ $posts->firstItem() }}–{{ $posts->lastItem() }}
                </span>
                of
                <span class="text-kt-text">
                    {{ $posts->total() }}
                </span>
                posts
            </p>
            <div>
                {{ $posts->links() }}
            </div>
        </div>
    </section>

</div>
@endsection