<?php

use App\Http\Controllers\FeedController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TweetController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/', [FeedController::class, 'HomeFeed'])->name('Home');
    Route::post('feed/home', [FeedController::class, 'ApiHomeFeed']);

    Route::post('tweet', [TweetController::class, 'store']);
    Route::get('tweets/{id}', [TweetController::class, 'show']);
    Route::post('like', [LikeController::class, 'store']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('auth/user', function () {
    if (!Auth::check()) {
        return response()->json(['user' => null]);
    }

    $user = Auth::user();
    return response()->json([
        'user' => [
            'id'              => $user->id,
            'full_name'       => $user->full_name,
            'username'        => $user->username,
            'email'           => $user->email,
            'bio'             => $user->bio,
            'cover_photo'     => $user->cover_photo,
            'profile_picture' => $user->profile_picture,
        ],
    ]);
});

require __DIR__ . '/auth.php';
