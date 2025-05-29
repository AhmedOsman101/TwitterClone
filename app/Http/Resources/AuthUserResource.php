<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthUserResource extends JsonResource {
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array {
    $unreadNotificationsCount = $this->unreadNotifications->count();

    return [
      "id"             => $this->id,
      "fullName"       => $this->fullName,
      "username"       => $this->username,
      "profilePicture" => $this->profilePicture,
      "unreadCount"    => $unreadNotificationsCount,
    ];
  }
}
