<?php

namespace App\Http\Resources;

use AllowDynamicProperties;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

#[AllowDynamicProperties] class TweetResource extends JsonResource {
  use Helpers;

  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array {
    return [
      "id"            => $this->id,
      "userId"        => $this->userId,
      "body"          => $this->body,
      "likesCount"    => $this->likesCount,
      "commentsCount" => $this->commentsCount,
      "liked"         => $this->when(isset($this->liked), $this->liked),
      "createdAt"     => (new Carbon($this->createdAt))->isoFormat('h:mm A • MMM d, Y'),
      "duration"      => $this->getDuration($this->createdAt),
      "user"          => (new ShortUserResource($this->user))->resolve(),
    ];
  }
}
