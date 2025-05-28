<?php

namespace App\Http\Resources;

use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource {
  use Helpers;

  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array {
    return [
      "id"          => $this->id,
      "userId"      => $this->userId,
      "tweetId"     => $this->tweetId,
      "body"        => $this->body,
      "liked"       => $this->liked,
      "likes_count" => $this->likes_count,
      "duration"    => $this->getDuration($this->created_at),
      "created_at"  => $this->created_at,
      "user"        => (new ShortUserResource($this->user))->resolve(),
    ];
  }
}
