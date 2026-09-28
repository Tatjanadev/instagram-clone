<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Support\Facades\Storage;

class PostRepository
{
    public function getAllPosts()
    {
        return Post::with(['images', 'user'])
            ->latest()
            ->get();
    }

    public function getPostById(int $id): Post
    {
        return Post::with('images')->findOrFail($id);
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

    public function updatePost(Post $post, array $data): Post
    {
        $post->update([
            'title' => $data['title'],
            'description' => $data['description'],
        ]);

        // Only replace images if the user selected new ones
        if (!empty($data['images'])) {
            foreach ($post->images as $image) {
                // Delete the physical file only if it is a real user upload.
                if (str_starts_with($image->image_path, 'posts/')) {
                    Storage::disk('public')->delete($image->image_path);
                }
                $image->delete();
            }

            foreach ($data['images'] as $image) {
                $path = $image->store('posts', 'public');

                PostImage::create([
                    'post_id' => $post->id,
                    'image_path' => $path,
                ]);
            }
        }

        return $post->load('images');
    }

    public function deletePost(Post $post): void
    {
        foreach ($post->images as $image) {
            if (str_starts_with($image->image_path, 'posts/')) {
                Storage::disk('public')->delete($image->image_path);
            }
        }
        $post->delete();
    }
}
