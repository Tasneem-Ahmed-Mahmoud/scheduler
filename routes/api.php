<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Profile\ProfileController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('login', [LoginController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [LogoutController::class, 'logout']);
        Route::get('profile', [ProfileController::class, 'show']);
        Route::put('profile', [ProfileController::class, 'update']);
    });
});

Route::middleware('auth:sanctum')->prefix('posts')->group(function () {
    Route::post('/', [PostController::class, 'store']);
    Route::get('/', [PostController::class, 'index']);
    Route::put('{post}', [PostController::class, 'update']);
    Route::delete('{post}', [PostController::class, 'destroy']);
});