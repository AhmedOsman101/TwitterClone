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
            "id"              => $this->id,
            "full_name"       => $this->full_name,
            "username"        => $this->username,
            "profile_picture" => $this->profile_picture,
            "unreadCount"     => $unreadNotificationsCount,
        ];
    }
}
