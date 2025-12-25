<?php

namespace App\Mail;

use App\Models\NewsletterSubscriber;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PostPublishedNewsletter extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public NewsletterSubscriber $subscriber,
        public Post $post
    ) {}

    public function build()
    {
        $unsubscribeUrl = route('newsletter.unsubscribe.link', [
            'subscriber'    => $this->subscriber->id,
            'token'         => $this->subscriber->unsubscribe_token,
        ]);

        $postUrl = route('front.posts.show', $this->post);

        return $this
            ->subject('New on ' . config('app.name') . ': ' . $this->post->title)
            ->markdown('mail.newsletter.post_published', [
                'subscriber'        => $this->subscriber,
                'post'              => $this->post,
                'posturl'           => $postUrl,
                'unsubscribeurl'    => $unsubscribeUrl,
            ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Post Published Newsletter',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.newsletter.post_published',
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
