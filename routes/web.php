<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



Route::middleware('auth')->group(
    function () {
        Route::get('/', function () {
            return Inertia::render('Home');
        })->name('Home');
    }
);

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

Route::prefix('user')->group(function () {

    Route::get('/', [UserController::class, 'index']);

    Route::post(
        'logout',
        [AuthController::class, 'logout']
    )->name('logout');
});

Route::prefix('tweet')->group(function () {
    Route::post('/', [TweetController::class, 'store']);
    Route::get('/', [TweetController::class, 'index']);
});
