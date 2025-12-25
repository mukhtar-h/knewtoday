@php
use Illuminate\Support\Str;

/** @var \App\Models\Post|null $post */
$isEdit = isset($post) && $post->exists;

// Comma-separated tags for edit
$tagsValue = old('tags', $isEdit ? $post->tags->pluck('name')->join(', ') : '');
@endphp

<div class="grid gap-6 lg:grid-cols-[minmax(0,2fr)_minmax(0,1fr)]">

    {{-- MAIN COLUMN --}}
    <section class="space-y-4">

        {{-- Title --}}
        <div class="kt-card space-y-3 text-xs">
            <div class="space-y-1">
                <label for="title" class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                    Title
                </label>
                <input id="title"
                    name="title"
                    type="text"
                    value="{{ old('title', $isEdit ? $post->title : '') }}"
                    required
                    class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent"
                    placeholder="The mystery of the silent forest" />
                @error('title')
                <p class="text-[11px] text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Category --}}
            <div class="space-y-1">
                <label for="category_id" class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                    Category
                </label>
                <select id="category_id"
                    name="category_id"
                    required
                    class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-textMuted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">
                    <option value="">Select a category...</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        @selected(old('category_id', $isEdit ? $post->category_id : null) == $category->id)>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                @error('category_id')
                <p class="text-[11px] text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Thumbnail + Excerpt --}}
        <div class="kt-card space-y-4 text-xs">

            {{-- Thumbnail upload --}}
            <div class="space-y-1">
                <label for="thumbnail" class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                    Thumbnail image
                </label>
                <input id="thumbnail"
                    name="thumbnail"
                    type="file"
                    accept="image/*"
                    class="kt-input w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-textMuted file:mr-3 file:rounded-md file:border file:border-kt-border file:bg-kt-bg file:px-3 file:py-1.5 file:text-[11px] file:text-kt-text file:hover:border-kt-accent " />
                @error('thumbnail')
                <p class="text-[11px] text-red-400">{{ $message }}</p>
                @enderror

                @if($isEdit && $post->thumbnail_path)
                <div class="mt-2 flex items-center gap-3">
                    <img src="{{ asset('storage/'.$post->thumbnail_path) }}"
                        alt="Thumbnail"
                        class="h-16 w-16 rounded-md object-cover border border-kt-border/70">
                    <p class="text-[11px] text-kt-muted">
                        Current thumbnail
                    </p>
                </div>
                @endif
            </div>

            {{-- Excerpt --}}
            <div class="space-y-1">
                <label for="excerpt" class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                    Excerpt
                </label>
                <textarea id="excerpt"
                    name="excerpt"
                    rows="3"
                    class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent"
                    placeholder="Short summary of the story used on listing pages and for SEO meta description.">{{ old('excerpt', $isEdit ? $post->excerpt : '') }}</textarea>
                @error('excerpt')
                <p class="text-[11px] text-red-400">{{ $message }}</p>
                @enderror
                <p class="text-[10px] text-kt-muted">
                    This will be used as the meta description for SEO.
                </p>
            </div>
        </div>

        {{-- Content (WYSIWYG) --}}
        <div class="kt-card space-y-3 text-xs">
            <div class="flex items-center justify-between gap-2">
                <div>
                    <label class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                        Content
                    </label>
                    <p class="text-[11px] text-kt-textMuted">
                        Write the full story. You can format text, add links, and more.
                    </p>
                </div>
            </div>

            {{-- Hidden input + Trix editor --}}
            <input id="content"
                type="hidden"
                name="content"
                value="{{ old('content', $isEdit ? $post->content : '') }}">

            <trix-editor input="content"
                class="trix-content bg-kt-bg border border-kt-border rounded-lg px-3 py-2 text-xs text-kt-text"></trix-editor>

            @error('content')
            <p class="text-[11px] text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

    </section>

    {{-- SIDE COLUMN --}}
    <section class="space-y-4">

        {{-- Tags --}}
        <div class="kt-card space-y-2 text-xs">
            <label for="tags" class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                Tags
            </label>
            <input id="tags"
                name="tags"
                type="text"
                value="{{ $tagsValue }}"
                class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent"
                placeholder="mystery, ghost ship, unsolved" />
            @error('tags')
            <p class="text-[11px] text-red-400">{{ $message }}</p>
            @enderror
            <p class="text-[10px] text-kt-muted">
                Separate tags with commas. New tags will be created automatically.
            </p>
        </div>

        {{-- Info only (status + slug) --}}
        <div class="kt-card text-[11px] text-kt-textMuted space-y-3">
            <p>
                <span class="font-semibold text-kt-text">Status:</span>
                @if($isEdit)
                <span class="ml-1">
                    {{ ucfirst(str_replace('_', ' ', $post->status->value)) }}
                </span>
                @else
                <span class="ml-1">
                    Draft (new posts start as draft)
                </span>
                @endif
            </p>
            <p>
                <span class="font-semibold text-kt-text">Slug:</span>
                <span class="ml-1 text-kt-muted">
                    @if($isEdit)
                    {{ $post->slug }}
                    @else
                    Will be generated from the title
                    @endif
                </span>
            </p>
            <p class="text-[10px] text-kt-muted">
                Status changes (publish, under review, archive) are controlled from the Posts admin list.
            </p>
        </div>

        {{-- Submit --}}
        <div class="flex items-center justify-end gap-2">
            <a href="{{ route('admin.posts.index') }}"
                class="kt-btn-outline text-[11px]">
                Cancel
            </a>
            <button type="submit" class="kt-btn-primary text-[11px]">
                {{ $isEdit ? 'Update post' : 'Create post' }}
            </button>
        </div>

    </section>


</div>