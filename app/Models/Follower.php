<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Follower extends Model {
  /** @use HasFactory<\Database\Factories\FollowerFactory> */
  use HasFactory;

  public $timestamps = false;
  protected $guarded = [];

  /**
   * Get the user who is following.
   */
  public function follower(): BelongsTo {
    return $this->belongsTo(User::class, 'followerId');
  }

  /**
   * Get the user being followed.
   */
  public function followed(): BelongsTo {
    return $this->belongsTo(User::class, 'followedUserId');
  }

}
