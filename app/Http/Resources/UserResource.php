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
    return [
      "id"              => $this->id,
      "full_name"       => $this->full_name,
      "username"        => $this->username,
      "email"           => $this->email,
      "bio"             => $this->bio,
      "cover_photo"     => $this->cover_photo,
      "profile_picture" => $this->profile_picture,
      "created_at"      => (new Carbon($this->created_at))->isoFormat('MMMM Y'),
    ];
  }
}
