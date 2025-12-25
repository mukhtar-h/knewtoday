<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostCommented extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Comment $comment
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable)
    {
        $post           = $this->comment->post;
        $commentUser    = $this->comment->user;

        return [
            'kind'              => 'post_commented', // For Blade
            'post_id'           => $post?->id,
            'post_title'        => $post?->title,
            'comment_id'        => $this->comment->id,
            'commenter_name'    => $commentUser?->guest_name
                ?? $this->comment->guest_name
                ?? 'Guest',
            'excerpt'           => str()->limit(strip_tags($this->comment->body), 120),
            'url'               => $post
                ? route('front.posts.show', $post) . '#comment-' . $this->comment->id
                : null,
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $data = $this->toDatabase($notifiable);

        return (new MailMessage)
            ->subject('New comment on your post')
            ->line($data['commenter_name'] . ' commented on your post: "' . $data['post_title'] . '"')
            ->action('View comment', $data['url'] ?? url('/'))
            ->line('Thank you for publishing on ' . config('app.name') . '!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
