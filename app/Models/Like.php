<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model {
  /** @use HasFactory<\Database\Factories\LikeFactory> */
  use HasFactory;

  public const string CREATED_AT = 'createdAt';
  public const null UPDATED_AT = null;
  protected $guarded = [];

  public function user(): BelongsTo {
    return $this->belongsTo(User::class, "userId");
  }

  public function tweet(): BelongsTo {
    return $this->belongsTo(Tweet::class, "tweetId");
  }

  public function comment(): BelongsTo {
    return $this->belongsTo(Comment::class, "commentId");
  }

}
