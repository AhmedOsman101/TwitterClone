<?php

namespace App\Http\Resources;

use AllowDynamicProperties;
use App\Traits\Helpers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

#[AllowDynamicProperties] class TweetResource extends JsonResource {
  use Helpers;

  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array {
    return [
      "id"             => $this->id,
      "user_id"        => $this->user_id,
      "body"           => $this->body,
      "likes_count"    => $this->likes_count,
      "comments_count" => $this->comments_count,
      "liked"          => $this->when(isset($this->liked), $this->liked),
      "created_at"     => (new Carbon($this->created_at))->isoFormat('h:mm A • MMM d, Y'),
      "duration"       => $this->getDuration($this->created_at),
      "user"           => (new ShortUserResource($this->user))->resolve(),
    ];
  }
}
