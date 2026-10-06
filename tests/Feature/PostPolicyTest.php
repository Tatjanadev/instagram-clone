<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

test('post owner can update their own post', function () {
    $user = User::factory()->create();

    $post = Post::factory()->create([
        'user_id' => $user->id,
    ]);

    $canUpdate = Gate::forUser($user)->allows('update', $post);
    expect($canUpdate)->toBeTrue();
});

test('user cannot update another users post', function () {
    $owner = User::factory()->create();

    $otherUser = User::factory()->create();

    $post = Post::factory()->create([
        'user_id' => $owner->id,
    ]);

    $canUpdate = Gate::forUser($otherUser)->allows('update', $post);

    expect($canUpdate)->toBeFalse();
});

test('post owner can delete their own post', function () {
    $user = User::factory()->create();

    $post = Post::factory()->create([
        'user_id' => $user->id,
    ]);

    $canDelete = Gate::forUser($user)->allows('delete', $post);
    expect($canDelete)->toBeTrue();
});

test('user cannot delete another users post', function () {
    $postOwner = User::factory()->create();

    $otherUser = User::factory()->create();

    $post = Post::factory()->create([
        'user_id' => $postOwner->id,
    ]);

    $canDelete = Gate::forUser($otherUser)->allows('delete', $post);
    expect($canDelete)->toBeFalse();
});
