<?php

namespace App\Notifications;

use App\Enums\NotificationType;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class FollowNotification extends Notification {
  use Queueable;

  private int $followerId;

  /**
   * Create a new notification instance.
   */
  public function __construct(int $followerId) {
    $this->followerId = $followerId;
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
    $follower = User::find($this->followerId);

    return [
      'message'        => "{$follower->fullName} started following you",
      'username'       => $follower->username,
      'fullName'       => $follower->fullName,
      'profilePicture' => $follower->profilePicture,
      'type'           => NotificationType::Follow,
    ];
  }
}
