@php echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp
<rss version="2.0">
    <channel>
        <title>KNEWTODAY — Latest Stories</title>
        <link>{{ url('/') }}</link>
        <description>Documentary-style stories on mysteries, unexplained events, and the science behind them.</description>
        <language>en-us</language>
        <lastBuildDate>{{ optional($posts->first()->updated_at ?? null)?->toRfc2822String() }}</lastBuildDate>
        <generator>Laravel RSS</generator>

        @foreach($posts as $post)

            <item>
                <title><![CDATA[ {{ $post->title }} ]]></title>
                <link>{{ route('front.posts.show', $post->slug) }}</link>
                <guid>{{ route('front.posts.show', $post->slug) }}</guid>
                <pubDate>{{ optional($post->updated_at)->toRfc2822String() }}</pubDate>

                <description><![CDATA[
                    {{ $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->content), 300) }}
                ]]></description>
            </item>
        @endforeach
        
    </channel>
</rss>
