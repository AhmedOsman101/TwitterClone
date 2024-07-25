<?php

namespace App\Notifications;

use App\Models\User;
use App\Enums\NotificationType;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class CommentNotification extends Notification {
    use Queueable;

    public int $tweet_id;

    /**
     * Create a new notification instance.
     */
    public function __construct($tweet_id) {
        $this->tweet_id = $tweet_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array {
        $user = Auth::user();

        return [
            'message'         => "{$user->full_name} replied to your tweet",
            'username'        => $user->username,
            'full_name'       => $user->full_name,
            'profile_picture' => $user->profile_picture,
            'tweet_id'        => $this->tweet_id,
            'type'            => NotificationType::Reply,
        ];
    }
}
