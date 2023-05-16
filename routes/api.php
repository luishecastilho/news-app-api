<?php

use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\{
    AuthController,
    UserController,
    FeedController
};

Route::middleware('auth:api')->group(function () {
    Route::prefix('auth')->group(function () {
        // login oauth...
        Route::post('/', [AuthController::class, 'store'])->name('auth.store');
        Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    });

    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::put('/', [UserController::class, 'update'])->name('auth.update');
        Route::put('/preferences', [UserController::class, 'savePreferences'])->name('auth.savePreferences');
    });

    Route::prefix('feed')->group(function () {
        Route::get('/', [FeedController::class, 'index'])->name('feed.index');
        Route::put('/preferences', [FeedController::class, 'savePreferences'])->name('feed.savePreferences');
        Route::get('/article/{id}', [ArticleController::class, 'index'])->name('article.index')->where('id', '[0-9]+');
    });
});
