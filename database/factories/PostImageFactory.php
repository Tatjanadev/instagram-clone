<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

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
        $demoImages = collect(Storage::disk('public')->files('demo/posts'))
        ->filter(fn ($path) => in_array(
            strtolower(pathinfo($path, PATHINFO_EXTENSION)),
            ['jpg', 'jpeg', 'png', 'webp']
        ))
        ->values()
        ->all();

    return [
        'post_id' => Post::factory(),
        'image_path' => fake()->randomElement($demoImages),
    ];
    }
}
