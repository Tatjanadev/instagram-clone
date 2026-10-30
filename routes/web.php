<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Settings\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::post('language/{locale}', function (Request $request, string $locale) {
    if (! in_array($locale, ['en', 'cy', 'nb'], true)) {
        abort(404);
    }
    // Save the selected language in the user's session.
    $request->session()->put('locale', $locale);

    return back();
})->name('language.update');

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

    Route::get('likes', [LikeController::class, 'index'])
        ->name('likes.index');

    Route::post('posts/{postId}/like', [LikeController::class, 'store'])
        ->name('posts.like');

    Route::delete('posts/{postId}/like', [LikeController::class, 'destroy'])
        ->name('posts.unlike');

    Route::get('posts/{postId}/likes', [LikeController::class, 'likedBy'])
        ->name('posts.liked-by');

        Route::get('posts/{post}/comments', [CommentController::class, 'index'])
    ->name('comments.index');

    Route::post('posts/{post}/comments', [CommentController::class, 'store'])
        ->name('comments.store');

    Route::put('comments/{comment}', [CommentController::class, 'update'])
        ->name('comments.update');

    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])
        ->name('comments.destroy');
});

require __DIR__.'/settings.php';
