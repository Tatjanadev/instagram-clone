<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Follow;
use App\Models\Like;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(10)->create();

        $posts = Post::factory(30)
            ->state(function () use ($users) {
                return [
                    'user_id' => $users->random()->id,
                ];
            })
            ->create();

        $demoImages = collect(Storage::disk('public')->files('demo/posts'))
            ->filter(fn ($path) => in_array(
                strtolower(pathinfo($path, PATHINFO_EXTENSION)),
                ['jpg', 'jpeg', 'png', 'webp']
            ))
            ->values();

        $posts->each(function (Post $post, int $index) use ($demoImages) {
            PostImage::factory()->create([
                'post_id' => $post->id,
                'image_path' => $demoImages[$index],
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
