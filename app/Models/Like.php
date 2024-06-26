<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model {
  use HasFactory;

  public const null UPDATED_AT = null;
  protected $fillable = [
    'user_id',
    'tweet_id',
    'comment_id',
  ];

  public function user (): BelongsTo {
    return $this->belongsTo(User::class);
  }

  public function tweet (): BelongsTo {
    return $this->belongsTo(Tweet::class);
  }

  public function comment (): BelongsTo {
    return $this->belongsTo(Comment::class);
  }
}
