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
    Route::get('/', 'UserController@index');

    Route::post('register', 'UserController@register')->name('register');
});
