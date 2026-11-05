<?php
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('comments endpoint returns the correct resource data', function () {
    $postOwner = User::factory()->create();

    $post = Post::factory()->create([
        'user_id' => $postOwner->id,
    ]);

    $commenter = User::factory()->create([
        'first_name' => 'Sarah',
    ]);

    $comment = Comment::create([
        'user_id' => $commenter->id,
        'post_id' => $post->id,
        'body' => 'Beautiful photo!',
    ]);

      // Request the comments through the real controller.
    $response = $this->actingAs($postOwner)
        ->getJson(route('comments.index', $post));

        // Check the returned JSON structure and values.
    $response->assertOk()
        ->assertJsonPath('data.0.id', $comment->id)
        ->assertJsonPath('data.0.body', 'Beautiful photo!')
        ->assertJsonPath('data.0.user.id', $commenter->id)
        ->assertJsonPath('data.0.user.first_name', 'Sarah')
        ->assertJsonPath('data.0.user.username', $commenter->username)
        ->assertJsonPath('data.0.user.last_name', $commenter->last_name)
        ->assertJsonPath(
            'data.0.user.profile_photo_path',
            $commenter->profile_photo_path
        );
});

