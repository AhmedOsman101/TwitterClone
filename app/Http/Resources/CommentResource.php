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
  public function toArray (Request $request): array {
    return [
      "id"          => $this->id,
      "user_id"     => $this->user_id,
      "tweet_id"    => $this->tweet_id,
      "body"        => $this->body,
      "likes_count" => $this->likes_count,
      "duration"    => $this->getDuration($this->created_at),
      "created_at"  => $this->created_at,
      "liked"       => $this->liked,
      "user"        => (new TweetUserResource($this->user))->resolve(),
    ];
  }
}
