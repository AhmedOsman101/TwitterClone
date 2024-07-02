<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
  use HasFactory, Notifiable, HasApiTokens;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'full_name',
    'username',
    'email',
    'bio',
    'profile_picture',
    'cover_photo',
    'password',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  public function tweets (): HasMany {
    return $this->hasMany(Tweet::class);
  }

  public function comments (): HasMany {
    return $this->hasMany(Comment::class);
  }

  public function likes (): HasMany {
    return $this->hasMany(Like::class);
  }

  // Users this user is following
  public function following (): HasMany {
    return $this->hasMany(Follower::class, 'follower_id');
  }

  // Users that are following this user
  public function followers (): HasMany {
    return $this->hasMany(Follower::class, 'followed_user_id');
  }

  public function notifications (): HasMany {
    return $this->hasMany(Notification::class);
  }

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts (): array {
    return [
      'email_verified_at' => 'datetime',
      'password'          => 'hashed',
    ];
  }
}
