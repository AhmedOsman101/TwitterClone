<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class LikeNotification extends Notification {
  use Queueable;


  public string $message;
  public int $tweet_id;

  /**
   * Create a new notification instance.
   */
  public function __construct (string $message, int $tweet_id) {
    $this->tweet_id = $tweet_id;
    $this->message = $message;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @return array<int, string>
   */
  public function via (object $notifiable): array {
    return ['database'];
  }


  /**
   * Get the array representation of the notification.
   *
   * @return array<string, mixed>
   */
  public function toArray (object $notifiable): array {
    $user = Auth::user();

    return [
      'message'         => $this->message,
      'username'        => $user->username,
      'full_name'       => $user->full_name,
      'profile_picture' => $user->profile_picture,
      'tweet_id'        => $this->tweet_id,
      'type'            => "like",
    ];
  }
}
