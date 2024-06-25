<?php
/** @noinspection ALL */

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TweetController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {

  Route::get('/',
    [FeedController::class, 'HomeFeed']
  )->name('Home');

  Route::get('tweet/{id}',
    [TweetController::class, 'show']
  )->name('tweet.show');

  Route::post('tweet',
    [TweetController::class, 'store']
  )->name('tweet.store');

  Route::post('like', [LikeController::class, 'store']);

  Route::post('comments',
    [CommentController::class, 'store']
  )->name('comment.store');

  Route::get('/profile',
    [ProfileController::class, 'edit']
  )->name('profile.edit');

  Route::patch('/profile',
    [ProfileController::class, 'update']
  )->name('profile.update');

  Route::delete('/profile',
    [ProfileController::class, 'destroy']
  )->name('profile.destroy');

});

require __DIR__ . '/auth.php';
