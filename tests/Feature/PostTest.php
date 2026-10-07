<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('authenticated user can create a post', function () {
    Storage::fake('public');

    $user = User::factory()->create();

    $image = UploadedFile::fake()->image('post.jpg');

    $response = $this->actingAs($user)
        ->post('/posts', [
            'title' => 'Test Post',
            'description' => 'Test Description',
            'images' => [$image],
        ]);
    $response->assertRedirect(route('posts.index'));

    $this->assertDatabaseHas('posts', [
        'user_id' => $user->id,
        'title' => 'Test Post',
        'description' => 'Test Description',
    ]);
});

test('authenticated user can update a post', function () {
    $user = User::factory()->create();

    $post = Post::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this->actingAs($user)
        ->patch("/posts/{$post->id}", [
            'title' => 'Updated Test Post',
            'description' => 'Updated Test Description',
        ]);
    $response->assertRedirect(route('posts.show', $post->id));

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'user_id' => $user->id,
        'title' => 'Updated Test Post',
        'description' => 'Updated Test Description',
    ]);
});
