@extends('layouts.admin')

@section('title', 'KNEWTODAY — Admin Categories')

@section('page_title', 'Categories')
@section('page_subtitle', 'Organize your stories by main themes like Mystery, Space, Ocean & more.')

@section('content')

{{-- Flash message --}}
@if(session('status'))
<div class="mb-4 text-xs px-3 py-2 rounded-lg bg-emerald-500/10 border border-emerald-500/50 text-emerald-100">
    {{ session('status') }}
</div>
@endif

<div class="space-y-5">

    {{-- Header bar --}}
    <div class="flex items-center justify-between">
        <h2 class="text-xs font-semibold text-kt-text uppercase tracking-[0.16em]">
            All Categories
        </h2>

        @can('create', App\Models\Category::class)
        <a href="{{ route('admin.categories.create') }}"
            class="kt-btn-primary text-[11px]">
            + New Category
        </a>
        @endcan
    </div>

    <section class="kt-card">
        <div class="overflow-x-auto">
            <table class="kt-admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Description</th>
                        <th>Posts</th>
                        <th>Updated</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($categories as $category)
                    <tr>
                        {{-- Name --}}
                        <td class="text-kt-text text-xs">
                            {{ $category->name }}
                        </td>

                        {{-- Slug --}}
                        <td class="text-kt-textMuted text-xs">
                            {{ $category->slug }}
                        </td>

                        {{-- Description --}}
                        <td class="text-kt-textMuted text-xs max-w-xs">
                            {{ $category->description ?? '—' }}
                        </td>

                        {{-- Posts count --}}
                        <td class="text-kt-textMuted text-xs">
                            {{ $category->posts()->count() }}
                        </td>

                        {{-- Updated date --}}
                        <td class="text-kt-textMuted text-xs whitespace-nowrap">
                            {{ $category->updated_at->format('M j, Y') }}
                            <div class="text-[10px] text-kt-muted">
                                {{ $category->updated_at->diffForHumans() }}
                            </div>
                        </td>

                        {{-- Actions --}}
                        <td class="text-right">
                            <div class="flex flex-col items-start gap-1 text-[11px]">

                                @can('update', $category)
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                    class="text-kt-accent hover:underline">
                                    Edit
                                </a>
                                @endcan

                                @can('delete', $category)
                                <form action="{{ route('admin.categories.destroy', $category) }}"
                                    method="POST"
                                    onsubmit="return confirm('Delete this category?');">
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
                        <td colspan="6"
                            class="text-center text-xs text-kt-muted py-6">
                            No categories found.
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
                <span class="text-kt-text">{{ $categories->firstItem() }}–{{ $categories->lastItem() }}</span>
                of
                <span class="text-kt-text">{{ $categories->total() }}</span>
                categories
            </p>

            {{ $categories->links() }}
        </div>
    </section>
</div>
@endsection