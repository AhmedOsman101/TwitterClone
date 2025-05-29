<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model {
  /** @use HasFactory<\Database\Factories\CommentFactory> */
  use HasFactory;

  public const string CREATED_AT = 'createdAt';
  public const null UPDATED_AT = null;

  protected $fillable = [
    'userId',
    'tweetId',
    'body',
  ];

  public function user(): BelongsTo {
    return $this->belongsTo(User::class, "userId");
  }

  public function tweet(): BelongsTo {
    return $this->belongsTo(Tweet::class, "tweetId");
  }

  public function likes(): HasMany {
    return $this->hasMany(Like::class, "commentId");
  }

}
