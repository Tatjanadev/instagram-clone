<?php

use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Settings\UserController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('profile', [UserController::class, 'show'])
        ->name('profile.show');

    Route::get('users', [UserController::class, 'index'])
        ->name('users.index');

    Route::get('users/{username}', [UserController::class, 'showPublic'])
        ->name('users.show');

    Route::resource('posts', PostController::class);

    Route::post('users/{followingId}/follow', [FollowController::class, 'store'])
        ->name('users.follow');

    Route::delete('users/{followingId}/follow', [FollowController::class, 'destroy'])
        ->name('users.unfollow');
});

require __DIR__.'/settings.php';
