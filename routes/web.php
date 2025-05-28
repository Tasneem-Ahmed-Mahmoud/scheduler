<?php

use App\Http\Controllers\Web\Admin\PlatformController;
use App\Http\Controllers\Web\Admin\PostController;
use App\Http\Controllers\Web\Admin\StatisticsController;
use App\Http\Controllers\Web\User\PlatformController as UserPlatformController;
use App\Http\Controllers\Web\User\PostController as UserPostController;
use App\Http\Middleware\checkUserIsAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;





Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', checkUserIsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('platforms', PlatformController::class)->middleware('auth')->names('platforms');
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
});

Route::middleware('auth')->prefix('user')->name('user.')->group(function () {
    Route::get('/home', [UserPostController::class, 'index'])->name('home');
    Route::resource('posts', UserPostController::class)->names('posts');
    Route::get('platforms', [UserPlatformController::class, 'index'])->name('platforms');
    Route::post('/platforms/sync', [UserPlatformController::class, 'sync'])->name('platforms.sync');

    
});


Route::get('/admin/statistics', [StatisticsController::class, 'index'])
    ->name('admin.statistics');
