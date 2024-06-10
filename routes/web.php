<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TweetController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::middleware('auth')->group(
    function () {
        Route::get('/', [FeedController::class, 'HomeFeed'])->name('Home');
        Route::post(
            'user/logout',
            [AuthController::class, 'logout']
        )->name('logout');

        Route::post('tweet', [TweetController::class, 'store']);
        Route::post('like', [LikeController::class, 'store']);
    }

);

// Route::get('/test', [FeedController::class, 'HomeFeed']);

Route::get(
    'register',
    function () {
        return Inertia::render('Auth/Register');
    }
)->name('register');

Route::post(
    'register',
    [AuthController::class, 'register']
);

Route::get(
    'login',
    function () {
        return Inertia::render('Auth/Login');
    }
)->name('login');

Route::post(
    'login',
    [AuthController::class, 'login']
);
