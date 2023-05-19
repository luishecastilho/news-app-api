<?php

use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\{
    AuthController,
    UserController,
    FeedController,
    ArticleController
};

Route::post('/auth/register', [AuthController::class, 'store'])->name('auth.store');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');

Route::prefix('feed')->group(function () {
    Route::get('/', [FeedController::class, 'index'])->name('feed.index');
    Route::get('/filter-data', [FeedController::class, 'filterData'])->name('feed.filterData');
    Route::get('/article/{id}', [ArticleController::class, 'index'])->name('article.index')->where('id', '[0-9]+');
});

Route::middleware('auth:api')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::put('/', [UserController::class, 'update'])->name('user.update');
        Route::get('/preferences', [UserController::class, 'getPreferences'])->name('user.getPreferences');
        Route::get('/preferences-string', [UserController::class, 'getPreferencesString'])->name('user.getPreferencesString');
        Route::put('/preferences', [UserController::class, 'savePreferences'])->name('user.savePreferences');
    });


    Route::prefix('auth/feed')->group(function () {
        Route::get('/', [FeedController::class, 'index'])->name('feed.index');
        Route::get('/filter-data', [FeedController::class, 'filterData'])->name('feed.filterData');
    });
});
