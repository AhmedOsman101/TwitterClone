<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tweet extends Model {
  use HasFactory;

  public const null UPDATED_AT = null;
  protected $fillable = [
    'user_id',
    'body',
  ];

  public function user (): BelongsTo {
    return $this->belongsTo(User::class);
  }

  public function comments () {
    return $this->hasMany(Comment::class);
  }

  public function likes () {
    return $this->hasMany(Like::class);
  }
}
