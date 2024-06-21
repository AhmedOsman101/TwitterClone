<?php

use App\Http\Controllers\FeedController;
use App\Http\Controllers\TweetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('like', [LikeController::class, 'getUserLikedPosts']);

Route::get('tweets/{id}', [TweetController::class, 'show']);
Route::get('feed/home', [FeedController::class, 'ApiHomeFeed']);
