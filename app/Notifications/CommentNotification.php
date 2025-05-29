<?php

namespace App\Notifications;

use App\Enums\NotificationType;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class CommentNotification extends Notification {
  use Queueable;

  public int $tweetId;

  /**
   * Create a new notification instance.
   */
  public function __construct($tweetId) {
    $this->tweetId = $tweetId;
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
      'message'        => "{$user->fullName} replied to your tweet",
      'username'       => $user->username,
      'fullName'       => $user->fullName,
      'profilePicture' => $user->profilePicture,
      'tweetId'        => $this->tweetId,
      'type'           => NotificationType::Reply,
    ];
  }
}
