<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentReplied extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Comment $replyComment
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
        $post = $this->replyComment->post;
        $parent = $this->replyComment->parent;


        return [
            'kind'          => 'comment_replied', // for blade
            'post_id'       => $post?->id,
            'post_title'    => $post?->title,
            'reply_id'      => $this->replyComment->id,
            'parent_id'     => $parent?->id,
            'replier_name'  => $this->replyComment->guest_name ?? 'Guest',
            'excerpt'       => str()->limit(strip_tags($this->replyComment->body), 120),
            'url'           => $post ? route('front.posts.show', $post) . '#comment-' . $this->replyComment->id : null,

        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Someone replied to your comment')
            ->line('Your comment has a new reply')
            ->action('View reply', $this->toDatabase($notifiable)['url'] ?? url('/'))
            ->line('Thank you for reading ' . config('app.name') . '!');
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
