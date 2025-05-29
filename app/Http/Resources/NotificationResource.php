<?php

namespace App\Http\Resources;

use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource {
  use Helpers;

  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array {
    return [
      "id"             => $this->id,
      "type"           => $this->data['type'],
      "username"       => $this->data['username'],
      "fullName"       => $this->data['fullName'],
      "message"        => $this->data['message'],
      "profilePicture" => $this->data['profilePicture'],
      "tweetId"        => $this->data['tweetId'] ?? null,
      "createdAt"      => $this->getDuration($this->createdAt),
      "readAt"         => $this->readAt !== null ? $this->getDuration($this->readAt) : null,
    ];
  }
}
