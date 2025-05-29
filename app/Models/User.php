<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
  /** @use HasFactory<\Database\Factories\UserFactory> */
  use HasFactory, Notifiable, HasApiTokens;

  public const string CREATED_AT = 'createdAt';
  public const string UPDATED_AT = 'updatedAt';

  /**
   * The attributes that are mass assignable.
   *
   * @var list<string>
   */
  protected $fillable = [
    'fullName',
    'username',
    'email',
    'bio',
    'profilePicture',
    'coverPhoto',
    'password',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var list<string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  public function tweets(): HasMany {
    return $this->hasMany(Tweet::class, "userId");
  }

  public function comments(): HasMany {
    return $this->hasMany(Comment::class, "userId");
  }

  public function likes(): HasMany {
    return $this->hasMany(Like::class, "userId");
  }

  // Users this user is following
  public function following(): HasMany {
    return $this->hasMany(Follower::class, 'followerId');
  }

  // Users that are following this user
  public function followers(): HasMany {
    return $this->hasMany(Follower::class, 'followedUserId');
  }

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array {
    return [
      'email_verified_at' => 'datetime',
      'password'          => 'hashed',
    ];
  }
}
