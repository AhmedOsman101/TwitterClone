<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tweet extends Model {
  /** @use HasFactory<\Database\Factories\TweetFactory> */
  use HasFactory;

  public const string CREATED_AT = 'createdAt';
  public const string UPDATED_AT = 'updatedAt';

  protected $guarded = [];

  public function user(): BelongsTo {
    return $this->belongsTo(User::class, "userId");
  }

  public function comments(): HasMany {
    return $this->hasMany(Comment::class, "tweetId");
  }

  public function likes(): HasMany {
    return $this->hasMany(Like::class, "tweetId");
  }
}
