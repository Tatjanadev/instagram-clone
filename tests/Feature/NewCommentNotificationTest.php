<?php

use App\Models\Post;
use App\Models\User;
use App\Notifications\NewCommentNotification;
use App\Services\CommentService;
use Illuminate\Support\Facades\Notification;

test('post owner receives notification when another user comments', function () {
    Notification::fake();

    $postOwner = User::factory()->create();
    $commenter = User::factory()->create();

    $post = Post::factory()->create([
        'user_id' => $postOwner->id,
    ]);

    app(CommentService::class)->create(
        $commenter->id,
        $post->id,
        'Nice post!'
    );
    Notification::assertSentTo(
        $postOwner,
        NewCommentNotification::class
    );
});

test('post owner does not receive notification for their own comment', function () {
    Notification::fake();

    $postOwner = User::factory()->create();

    $post = Post::factory()->create([
        'user_id' => $postOwner->id,
    ]);

    app(CommentService::class)->create(
        $postOwner->id,
        $post->id,
        'My own comment!'
    );

    Notification::assertNothingSent();
});
