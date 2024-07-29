<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TweetController;
use App\Http\Resources\AuthUserResource;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get(
        'user',
        function (Request $request) {
            return response()->json(AuthUserResource::make($request->user())->resolve());
        }
    )->name('auth.user');

    Route::get(
        'user/full',
        function (Request $request) {
            return response()->json(UserResource::make($request->user())->resolve());
        }
    )->name('auth.user.full');

    Route::get(
        'user/notifications',
        [NotificationController::class, 'index']
    )->name('auth.user.notifications');

    Route::get(
        'follower/suggest',
        [FollowerController::class, 'randomFollowers']
    )->name('follower.suggest');
});



Route::get('like', [LikeController::class, 'getUserLikedPosts']);

Route::get('comments', [CommentController::class, 'index'])->name('comments.index');
Route::get('comments/{id}', [CommentController::class, 'show'])->name('comments.show');

Route::get(
    'tweets/{id}',
    [TweetController::class, 'ApiShow']
)->name('tweets.api.show');

Route::get(
    'feed/home',
    [FeedController::class, 'ApiHomeFeed']
)->name('feed.home');

Route::get(
    'profile/feed',
    [FeedController::class, 'getUserFeed']
)->name('profile.feed');
