<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

test('guests are redirected to the login page', function () {
    $response = $this->get(route('profile.show'));
    $response->assertRedirect(route('login'));
});

test('authenticated users can visit the profile page', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('profile.show'));
    $response->assertOk();
});

test('authenticated user profile page receives the correct profile data', function () {
    $user = User::factory()->create();

    $post = Post::factory()->create([
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);
    $response = $this->get(route('profile.show'));
    $response->assertInertia(fn (Assert $page) => $page
        ->component('Profile')
        ->where('user.id', $user->id)
        ->where('user.username', $user->username)
        ->where('user.posts_count', 1)
        ->where('user.followers_count', 0)
        ->where('user.following_count', 0)
    );
});
