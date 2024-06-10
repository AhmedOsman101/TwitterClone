<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\TweetController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(
    function () {
        Route::get('/', [FeedController::class, 'HomeFeed'])->name('Home');
        Route::post(
            'user/logout',
            [AuthController::class, 'logout']
        )->name('logout');

        Route::post('tweet', [TweetController::class, 'store']);
    }

);

// Route::get('/test', [FeedController::class, 'HomeFeed']);

Route::middleware('guest')->group(function () {
    Route::inertia('register', 'Auth/Register')->name('register');
    Route::post('register', [AuthController::class, 'register']);

    Route::inertia('login', 'Auth/Login')->name('login');
    Route::post('login', [AuthController::class, 'login']);
});


