@component('mail::message')
# New on {{ config('app.name') }}

**{{ $post->title }}**

@if($post->excerpt)
{{ $post->excerpt }}
@else
{{ \Illuminate\Support\Str::limit(strip_tags($post->content), 160) }}
@endif

@component('mail::button', ['url' => $postUrl])
Read the full story
@endcomponent

---

If you no longer want to receive these emails, you can unsubscribe at any time:

@component('mail::button', ['url' => $unsubscribeUrl])
Unsubscribe
@endcomponent

@endcomponent