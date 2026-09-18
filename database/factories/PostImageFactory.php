<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PostImage>
 */
class PostImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'post_id' => Post::factory(),
            'image_path' => fake()->randomElement([
                'post-images/post-1.jpg',
                'post-images/post-2.jpg',
                'post-images/post-3.jpg',
            ]),
        ];
    }
}
