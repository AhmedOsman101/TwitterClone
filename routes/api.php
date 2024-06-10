<?php

use App\Http\Controllers\LikeController;
use Illuminate\Support\Facades\Route;

Route::post('like', [LikeController::class, 'store']);
