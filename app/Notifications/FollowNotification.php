<?php

namespace App\Notifications;

use App\Models\User;
use App\Enums\NotificationType;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class FollowNotification extends Notification {
  use Queueable;

  private int $follower_id;

  /**
   * Create a new notification instance.
   */
  public function __construct(int $follower_id) {
    $this->follower_id = $follower_id;
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
    $follower = User::find($this->follower_id);

    return [
      'message'         => "{$follower->full_name} started following you",
      'username'        => $follower->username,
      'full_name'       => $follower->full_name,
      'profile_picture' => $follower->profile_picture,
      'type'            => NotificationType::Follow,
    ];
  }
}
