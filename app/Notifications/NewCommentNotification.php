<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCommentNotification extends Notification
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
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // Load the user who wrote the comment.
        $this->comment->loadMissing('user');

        $postUrl = route('posts.show', $this->comment->post_id);

        return (new MailMessage)
            ->subject('Someone commented on your InstaNest post!')
            ->markdown('emails.new-comment', [
                // $notifiable is the person receiving the email, meaning the post owner.
                'firstName' => $notifiable->first_name,
                'commenterName' => $this->comment->user->first_name,
                'commentBody' => $this->comment->body,
                'postUrl' => $postUrl,
            ]);
    }
}
