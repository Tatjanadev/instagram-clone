<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PostRepository
{
    /**
     * @return Collection<int, Post>
     */
    public function getAllPosts()
    {
        return Post::with(['images', 'user'])
            ->latest()
            ->get();
    }

    /**
     * Summary of getLatestPostPerUser
     * @param int $currentUserId
     * @return Collection<int, Post>|\Illuminate\Support\Collection<int, \stdClass>
     */
    public function getLatestPostPerUser(int $currentUserId)
    {
        return Post::with(['images', 'user'])
        ->where('user_id', '!=', $currentUserId)
        ->latest()
        ->get()
        ->unique('user_id')
        ->values();
    }

    /**
     * Summary of getPostById
     * @param int $id
     * @return Post
     */
    public function getPostById(int $id): Post
    {
        return Post::with(['images', 'user'])->findOrFail($id);
    }

    public function create(
        int $authorId,
        string $title,
        string $content
    ): Post {
        return Post::create([
            'user_id' => $authorId,
            'title' => $title,
            'description' => $content,
        ]);
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  array<int, UploadedFile>  $images
     */
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

    /**
     * @param  array<string, mixed>  $data
     */
    public function updatePost(Post $post, array $data): Post
    {
        $post->update([
            'title' => $data['title'],
            'description' => $data['description'],
        ]);

        // Only replace images if the user selected new ones
        if (! empty($data['images'])) {
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

    /**
     * Summary of deletePost
     * @param Post $post
     * @return void
     */
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
