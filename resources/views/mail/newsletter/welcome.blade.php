@component('mail::message')
    # Welcome to {{ config('app.name') }}

    Thank you for subscribing to our newsletter.
    You’ll receive updates when we publish new stories and important news.

    If you ever want to stop receiving these emails, you can unsubscribe anytime:

    @component('mail::button', ['url' => $unsubscribeUrl])
        Unsubscribe
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
