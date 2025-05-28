<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\PlatformController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\ProfileController;


Route::prefix('auth')->group(function () {
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('login', [LoginController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [LogoutController::class, 'logout']);
        Route::get('profile', [ProfileController::class, 'show']);
        Route::put('profile', [ProfileController::class, 'update']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
   
//posts
    Route::controller(PostController::class)->prefix('posts')->group(function () {
        Route::post('/', 'store');
        Route::get('/', 'index');
        Route::put('{post}', 'update');
        Route::delete('{post}', 'destroy');
    });

// platforms
    Route::controller(PlatformController::class)->prefix('platforms')->group(function () {
        Route::get('/', 'index');
        Route::post('/toggle', 'toggle');
    });

});