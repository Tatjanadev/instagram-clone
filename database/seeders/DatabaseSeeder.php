<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use App\Models\PostImage;
use App\Models\Follow;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users =User::factory(10)->create();

       $posts = Post::factory(30)
    ->state(function () use ($users) {
        return [
            'user_id' => $users->random()->id,
        ];
    })
    ->create();

        $posts->each(function (Post $post) {
            PostImage::factory(rand(1, 5))->create([
                'post_id' => $post->id,
            ]);
        });

        Comment::factory(60)
        ->state(function () use ($users, $posts) {
            return [
                'user_id' => $users->random()->id,
                'post_id' => $posts->random()->id,
            ];
        })
        ->create();

        $users->each(function (User $user) use ($posts) {
            $postsToLike = $posts->random(fake()->numberBetween(3, 8));

            $postsToLike->each(function (Post $post) use ($user) {
                Like::factory()->create([
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                ]);
            });
        });

        $users->each(function (User $user) use ($users) {
            $usersToFollow = $users
            ->where('id', '!=', $user->id)
            ->random(fake()->numberBetween(2, 5));

            $usersToFollow->each(function (User $userToFollow) use ($user) {
                Follow::factory()->create([
                    'follower_id' => $user->id,
                    'following_id' => $userToFollow->id,
                ]);
            });
        });


    }
}
