<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('profile', 'Profile')->name('profile.show');
    
    Route::resource('posts', PostController::class);
});

require __DIR__.'/settings.php';
