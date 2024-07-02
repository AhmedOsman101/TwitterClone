<?php
/** @noinspection ALL */

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TweetController;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {

  Route::post('auth/user',
    function () {
      return response()->json(Auth::check() ? UserResource::collection([Auth::user()])->resolve()[0] : null);
    })->name('auth.get');

  Route::get('/',
    [FeedController::class, 'HomeFeed']
  )->name('Home');

  Route::get('tweet/{id}',
    [TweetController::class, 'show']
  )->name('tweet.show');

  Route::post('tweet',
    [TweetController::class, 'store']
  )->name('tweet.store');

  Route::post('like',
    [LikeController::class, 'store']
  )->name('like.store');

  Route::post('comments',
    [CommentController::class, 'store']
  )->name('comment.store');

  Route::post('follower',
    [FollowerController::class, 'store']
  )->name('follower.store');

  Route::get("/profile/{username}",
    [ProfileController::class, 'index']
  )->name('profile.index');

  Route::get("/profile/{username}/edit",
    [ProfileController::class, 'edit']
  )->name('profile.edit');

  Route::patch('/profile',
    [ProfileController::class, 'update']
  )->name('profile.update');

  Route::delete('/profile',
    [ProfileController::class, 'destroy']
  )->name('profile.destroy');

  Route::inertia('notifications',
    'Notifications'
  )->name('notifications');

  Route::put('notifications',
    [NotificationController::class, 'update']
  )->name('notifications.update');

  Route::delete('notifications',
    [NotificationController::class, 'destroy']
  )->name('notifications.destroy');

});

require __DIR__ . '/auth.php';
