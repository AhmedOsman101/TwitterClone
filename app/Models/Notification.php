<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model {
  use HasFactory, SoftDeletes;

  public const null UPDATED_AT = null;
  protected $fillable = [
    'user_id',
    'comment_id',
    'like_id',
    'follow_id',
  ];
}
