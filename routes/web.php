<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TweetController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::inertia(
        '/test',
        'Test'
    )->name('test');

    //* Home route
    Route::get(
        '/',
        [FeedController::class, 'HomeFeed']
    )->name('Home');

    //* Tweet routes
    Route::prefix('tweet')->group(function () {
        Route::get(
            '/{id}',
            [TweetController::class, 'show']
        )->name('tweet.show');

        Route::post(
            '/',
            [TweetController::class, 'store']
        )->name('tweet.store');
    });

    //* Like routes
    Route::post(
        'like',
        [LikeController::class, 'store']
    )->name('like.store');

    //* Comment routes
    Route::post(
        'comments',
        [CommentController::class, 'store']
    )->name('comment.store');

    //* Follow routes
    Route::post(
        'follower',
        [FollowerController::class, 'store']
    )->name('follower.store');


    //* Profile routes
    Route::prefix('profile')->group(function () {
        Route::get(
            "/{username}",
            [ProfileController::class, 'index']
        )->name('profile.index');

        Route::get(
            "/{username}/edit",
            [ProfileController::class, 'edit']
        )->name('profile.edit');

        Route::patch(
            '/',
            [ProfileController::class, 'update']
        )->name('profile.update');

        Route::delete(
            '/',
            [ProfileController::class, 'destroy']
        )->name('profile.destroy');
    });

    //* Notification routes
    Route::prefix('notifications')->group(function () {
        Route::inertia(
            '/',
            'Notifications'
        )->name('notifications');

        Route::put(
            '/',
            [NotificationController::class, 'update']
        )->name('notifications.update');

        Route::delete(
            '/',
            [NotificationController::class, 'destroy']
        )->name('notifications.destroy');
    });
});

require __DIR__ . '/auth.php';
