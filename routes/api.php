<?php

use App\Http\Controllers\LikeController;
use Illuminate\Support\Facades\Route;

Route::get('like', [LikeController::class, 'getUserLikedPosts']);

