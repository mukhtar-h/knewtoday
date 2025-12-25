@component('mail::message')
    {{-- Main newsletter content (Markdown from admin form) --}}
    {!! nl2br(e($content)) !!}

    ---

    If you no longer wish to receive these emails, you can unsubscribe:

    @component('mail::button', ['url' => $unsubscribeUrl])
        Unsubscribe
    @endcomponent
@endcomponent
