<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');


Route::prefix('user')->group(function () {

    Route::get('/', [UserController::class, 'index']);

    Route::post(
        'register',
        [UserController::class, 'register']
    )->name('register');

    Route::post(
        'login',
        [UserController::class, 'login']
    )->name('login');

    Route::post(
        'logout',
        [UserController::class, 'logout']
    )->name('logout');

    Route::prefix('post')->group(function () {
        Route::post('/', [PostController::class, 'create']);
    });
});
