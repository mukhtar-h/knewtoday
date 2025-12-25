<?php

namespace App\Mail;

use App\Models\NewsletterSubscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterBroadcast extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public NewsletterSubscriber $subscriber,
        public string $subjectLine,
        public string $contentMarkdown
    ) {}

    public function build()
    {
        $unsubscribeUrl = route('newsletter.unsubscribe.link', [
            'subscriber'    => $this->subscriber->id,
            'token'         => $this->subscriber->unsubscribe_token,
        ]);

        return $this
            ->subject($this->subjectLine)
            ->markdown('mail.newsletter.broadcast', [
                'subscriber'        => $this->subscriber,
                'content'           => $this->contentMarkdown,
                'unsubscribeUrl'    => $unsubscribeUrl,
            ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Newsletter Broadcast',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.newsletter.broadcast',
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
