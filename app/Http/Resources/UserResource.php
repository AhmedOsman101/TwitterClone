<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource {
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray (Request $request): array {
    $allNotifications = NotificationResource::collection($this->notifications)->resolve();
    $unreadNotifications = NotificationResource::collection($this->unreadNotifications)->resolve();

    // Extract the IDs from the notifications
    $allNotificationIds = array_column($allNotifications, 'id');
    $unreadNotificationIds = array_column($unreadNotifications, 'id');

    // Find the IDs that are in $allNotifications but not in $unreadNotifications
    $readNotificationIds = array_diff($allNotificationIds, $unreadNotificationIds);

    // Filter the $allNotifications array to get only the read notifications
    $readNotifications = array_filter($allNotifications, function ($notification) use ($readNotificationIds) {
      return in_array($notification['id'], $readNotificationIds, true);
    });
    return [
      "id"              => $this->id,
      "full_name"       => $this->full_name,
      "username"        => $this->username,
      "email"           => $this->email,
      "bio"             => $this->bio,
      "cover_photo"     => $this->cover_photo,
      "profile_picture" => $this->profile_picture,
      "notifications"   => [
        "all"    => $allNotifications,
        "read"   => $readNotifications,
        "unread" => $unreadNotifications,
      ],
      "created_at"      => (new Carbon($this->created_at))->isoFormat('MMMM Y'),
    ];
  }
}
