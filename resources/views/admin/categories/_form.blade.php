<div class="kt-card space-y-4 max-w-xl">

    {{-- Name --}}
    <div class="space-y-1 text-xs">
        <label class="text-[11px] uppercase tracking-[0.18em] text-kt-textMuted">
            Name
        </label>
        <input type="text" name="name"
            value="{{ old('name', $category->name ?? '') }}"
            placeholder="Mystery"
            class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-sm text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent" />
        <p class="text-[10px] text-kt-muted">
            This appears on the site and in admin lists.
        </p>
        @error('name')
        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Slug --}}
    <div class="space-y-1 text-xs">
        <label class="text-[11px] uppercase tracking-[0.18em] text-kt-textMuted">
            Slug
        </label>
        <input type="text" name="slug"
            value="{{ old('slug', $category->slug ?? '') }}"
            placeholder="mystery"
            class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent" />
        <p class="text-[10px] text-kt-muted">
            Used in URLs like /category/mystery. Leave empty to generate from name.
        </p>
        @error('slug')
        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Description --}}
    <div class="space-y-1 text-xs">
        <label class="text-[11px] uppercase tracking-[0.18em] text-kt-textMuted">
            Description
        </label>
        <textarea name="description" rows="3"
            placeholder="Unexplained events, strange patterns, and stories that never fully close…"
            class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-sm text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">{{ old('description', $category->description ?? '') }}</textarea>
        <p class="text-[10px] text-kt-muted">
            Optional, but useful for admin context and SEO hints.
        </p>
        @error('description')
        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Actions --}}
    <div class="flex items-center gap-2 pt-2">
        <button type="submit" class="kt-btn-primary text-[11px]">
            {{ $submitLabel }}
        </button>

        <a href="{{ route('admin.categories.index') }}"
            class="kt-btn-outline text-[11px]">
            Cancel
        </a>
    </div>
</div>