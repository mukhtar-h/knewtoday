@php echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    {{-- Home --}}
    <url>
        <loc>{{ url('/') }}</loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    {{-- Static pages --}}
    <url>
        <loc>{{ route('front.posts.index') }}</loc>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
    </url>

    <url>
        <loc>{{ route('front.categories.index') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>

    <url>
        <loc>{{ route('front.tags.index') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.6</priority>
    </url>

    <url>
        <loc>{{ route('front.search') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.4</priority>
    </url>

    <url>
        <loc>{{ route('front.about') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.3</priority>
    </url>

    <url>
        <loc>{{ route('front.contact') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.3</priority>
    </url>

    {{-- Categories --}}
    @foreach($categories as $category)
        <url>
            <loc>{{ route('front.categories.show', $category->slug) }}</loc>
            @if($category->updated_at)
                <lastmod>{{ $category->updated_at->toAtomString() }}</lastmod>
            @endif
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
    @endforeach

    {{-- Tags --}}
    @foreach($tags as $tag)
        <url>
            <loc>{{ route('front.tag.show', $tag->slug) }}</loc>
            @if($tag->updated_at)
                <lastmod>{{ $tag->updated_at->toAtomString() }}</lastmod>
            @endif
            <changefreq>weekly</changefreq>
            <priority>0.4</priority>
        </url>
    @endforeach

    {{-- Posts --}}
    @foreach($posts as $post)
        <url>
            <loc>{{ route('front.posts.show', $post->slug) }}</loc>
            @if($post->updated_at)
                <lastmod>{{ $post->updated_at->toAtomString() }}</lastmod>
            @endif
            <changefreq>monthly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach

</urlset>
