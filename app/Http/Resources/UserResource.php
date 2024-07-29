<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $full_name
 * @property string $username
 * @property string $email
 * @property string $bio
 * @property string $cover_photo
 * @property string $profile_picture
 * @property int $followers_count
 * @property int $following_count
 * @property string $created_at
 * @property \Illuminate\Database\Eloquent\Collection $followers
 * @property \Illuminate\Database\Eloquent\Collection $following
 */
class UserResource extends JsonResource {
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array {
    return [
      "id"              => $this->id,
      "full_name"       => $this->full_name,
      "username"        => $this->username,
      "email"           => $this->email,
      "bio"             => $this->bio,
      "cover_photo"     => $this->cover_photo,
      "profile_picture" => $this->profile_picture,
      // "followers"       => ShortUserResource::collection($this->followers->pluck('follower'))->resolve(),
      "followers_count" => $this->followers_count,
      // "following"       => ShortUserResource::collection($this->following->pluck('followed'))->resolve(),
      "following_count" => $this->following_count,
      "created_at"      => (new Carbon($this->created_at))->isoFormat('MMMM Y'),
    ];
  }
}
