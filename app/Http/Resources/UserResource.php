<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $fullName
 * @property string $username
 * @property string $email
 * @property string $bio
 * @property string $coverPhoto
 * @property string $profilePicture
 * @property int $followersCount
 * @property int $followingCount
 * @property string $createdAt
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
      "id"             => $this->id,
      "fullName"       => $this->fullName,
      "username"       => $this->username,
      "email"          => $this->email,
      "bio"            => $this->bio,
      "coverPhoto"     => $this->coverPhoto,
      "profilePicture" => $this->profilePicture,
      // "followers"       => ShortUserResource::collection($this->followers->pluck('follower'))->resolve(),
      "followersCount" => $this->followersCount,
      // "following"       => ShortUserResource::collection($this->following->pluck('followed'))->resolve(),
      "followingCount" => $this->followingCount,
      "createdAt"      => (new Carbon($this->createdAt))->isoFormat('MMMM Y'),
    ];
  }
}
