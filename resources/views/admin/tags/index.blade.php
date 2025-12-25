@extends('layouts.admin')

@section('title', 'KNEWTODAY — Admin Tags')

@section('page_title', 'Tags')
@section('page_subtitle', 'Fine-tune how stories are grouped by topics like #signal, #disappearance, #experiment, and more.')

@section('content')

{{-- Flash message --}}
@if(session('status'))
<div class="mb-4 text-xs px-3 py-2 rounded-lg bg-emerald-500/10 border border-emerald-500/50 text-emerald-100">
    {{ session('status') }}
</div>
@endif

<div class="space-y-5">

    {{-- Filters / header bar --}}
    <section class="kt-card">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 text-xs">

            {{-- Search (optional, but ready for later) --}}
            <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                <h1 class="kt-section-title text-base">
                    Tags
                </h1>

                <form method="GET" action="{{ route('admin.tags.index') }}" class="flex flex-wrap items-center gap-2 text-[11px]">
                    <input type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search tags..."
                        class="px-2 py-1 rounded-md bg-kt-bg border border-kt-border text-[11px] text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent" />

                    <select name="sort"
                        class="px-2 py-1 rounded-md bg-kt-bg border border-kt-border text-[11px] text-kt-textMuted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">
                        <option value="popular" @selected(request('sort', 'popular' )==='popular' )>Most used</option>
                        <option value="name" @selected(request('sort')==='name' )>A–Z</option>
                    </select>

                    <button type="submit"
                        class="kt-btn-outline text-[11px]">
                        Apply
                    </button>
                </form>
            </div>


            {{-- Create button --}}
            @can('create', App\Models\Tag::class)
            <div class="md:w-auto flex items-center md:justify-end">
                <a href="{{ route('admin.tags.create') }}"
                    class="kt-btn-primary text-[11px]">
                    + New Tag
                </a>
            </div>
            @endcan

        </div>
    </section>

    {{-- Tags table --}}
    <section class="kt-card">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-xs font-semibold text-kt-text uppercase tracking-[0.16em]">
                All Tags
            </h2>
            <p class="text-[11px] text-kt-muted">
                Showing {{ $tags->firstItem() }}–{{ $tags->lastItem() }} of {{ $tags->total() }}
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="kt-admin-table">
                <thead>
                    <tr class="text-[11px] text-kt-muted border-b border-kt-border/70">
                        <th class="py-2 px-3 text-left">Name</th>
                        <th class="py-2 px-3 text-left">Slug</th>
                        <th class="py-2 px-3 text-left">Usage</th>
                        <th class="py-2 px-3 text-left">Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($tags as $tag)
                    <tr>
                        {{-- Name --}}
                        <td class="py-2 px-3 align-top">
                            {{ $tag->name }}
                        </td>
                        {{-- Slug --}}
                        <td class="py-2 px-3 align-top text-kt-muted">
                            {{ $tag->slug }}
                        </td>
                        {{-- Usage --}}
                        <td class="py-2 px-3 align-top text-kt-textMuted">
                            {{ $tag->posts_count }} post{{ $tag->posts_count === 1 ? '' : 's' }}
                        </td>
                        {{-- Actions --}}
                        <td class="py-2 px-3 align-top text-right">
                            <div class="flex flex-col items-start gap-1 text-[11px]">
                                @can('update', $tag)
                                <a href="{{ route('admin.tags.edit', $tag) }}"
                                    class="text-kt-accent hover:underline">
                                    Edit
                                </a>
                                @endcan

                                @can('delete', $tag)
                                <form action="{{ route('admin.tags.destroy', $tag) }}"
                                    method="POST"
                                    onsubmit="return confirm('Delete this tag?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-kt-textMuted hover:text-red-400">
                                        Delete
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>

                    @empty

                    <tr>
                        <td colspan="6" class="text-center text-xs text-kt-muted py-6">
                            No tags found. Try creating your first tag.
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
                <span class="text-kt-text">{{ $tags->firstItem() }}–{{ $tags->lastItem() }}</span>
                of
                <span class="text-kt-text">{{ $tags->total() }}</span>
                tags
            </p>
            {{ $tags->links() }}
        </div>
    </section>
</div>
@endsection