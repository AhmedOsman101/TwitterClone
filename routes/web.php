<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\TweetController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(
  function () {
    Route::get('/', [FeedController::class, 'HomeFeed'])->name('Home');
    Route::post('feed/home', [FeedController::class, 'ApiHomeFeed']);
    Route::post(
      'user/logout',
      [AuthController::class, 'logout']
    )->name('logout');

    Route::post('tweet', [TweetController::class, 'store']);
    Route::get('tweets/{id}', [TweetController::class, 'show']);
    Route::post('like', [LikeController::class, 'store']);
  }

);

// Route::get('/test', [FeedController::class, 'HomeFeed']);
//Route::get('/test', static fn() => Inertia::render('Pages/testing'));

Route::middleware('guest')->group(function () {
  Route::inertia('register', 'Auth/Register')->name('register');
  Route::post('register', [AuthController::class, 'register']);

  Route::inertia('login', 'Auth/Login')->name('login');
  Route::post('login', [AuthController::class, 'login']);
});

Route::post('auth/user', [AuthController::class, 'getAuthenticatedUser']);
