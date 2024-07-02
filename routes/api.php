<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\TweetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
  return $request->user();
})->middleware('auth:sanctum');

Route::get('like', [LikeController::class, 'getUserLikedPosts']);

Route::get('comments', [CommentController::class, 'index'])->name('comments.index');
Route::get('comments/{id}', [CommentController::class, 'show'])->name('comments.show');

Route::get(
  'tweets/{id}', [TweetController::class, 'ApiShow']
)->name('tweets.api.show');

Route::get(
  'feed/home', [FeedController::class, 'ApiHomeFeed']
)->name('feed.home');

Route::get(
  'profile/feed', [FeedController::class, 'getUserFeed']
)->name('profile.feed');

Route::get('follower/suggest/{id}',
  [FollowerController::class, 'randomFollowers']
)->name('follower.suggest');