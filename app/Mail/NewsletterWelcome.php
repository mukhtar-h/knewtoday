<?php

namespace App\Mail;

use App\Models\NewsletterSubscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterWelcome extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public NewsletterSubscriber $subscriber
    ) {}

    public function build()
    {
        $unsubscribeUrl = route('newsletter.unsubscribe.link', [
            'subscriber'    => $this->subscriber->id,
            'token'         => $this->subscriber->unsubscribe_token,
        ]);

        return $this
            ->subject('You are subscribed to ' . config('app.name'))
            ->markdown('mail.newsletter.welcome', [
                'subscriber'        => $this->subscriber,
                'unsubscribeUrl'    => $unsubscribeUrl,
            ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Newsletter Welcome',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.newsletter.welcome',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
