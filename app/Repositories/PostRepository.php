<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\PostImage;

class PostRepository
{
    public function getAllPosts()
    {
        return Post::with(['images', 'user'])
            ->latest()
            ->get();
    }

    public function createPost(int $userId, array $data, array $images): Post
    {
        $post = Post::create([
            'user_id' => $userId,
            'title' => $data['title'],
            'description' => $data['description'],
        ]);

        foreach ($images as $image) {
            $path = $image->store('posts', 'public');

            PostImage::create([
                'post_id' => $post->id,
                'image_path' => $path,
            ]);
        }

        return $post;
    }
}