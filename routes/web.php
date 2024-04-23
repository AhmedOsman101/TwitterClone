<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get(
    'register',
    function () {
        return Inertia::render('Register');
    }
)->name('register');

Route::post(
    'register',
    [UserController::class, 'register']
);

Route::get(
    'login',
    function () {
        return Inertia::render('Login');
    }
)->name('login');

Route::post(
    'login',
    [UserController::class, 'login']
);

Route::prefix('user')->group(function () {

    Route::get('/', [UserController::class, 'index']);

    Route::post(
        'logout',
        [UserController::class, 'logout']
    )->name('logout');

    Route::prefix('post')->group(function () {
        Route::post('/', [PostController::class, 'create']);
        Route::get('/', [PostController::class, 'index']);
    });
});
