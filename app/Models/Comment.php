<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model {
  use HasFactory;

  public const null UPDATED_AT = null;

  protected $fillable = [
    'userId',
    'tweetId',
    'body',
  ];

  public function user(): BelongsTo {
    return $this->belongsTo(User::class);
  }

  public function tweet(): BelongsTo {
    return $this->belongsTo(Tweet::class);
  }

  public function likes(): HasMany {
    return $this->hasMany(Like::class);
  }
}
