<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

class PostRepository
{
    /**
     * @return Collection<int, Post>
     */
    public function getAllPosts(): Collection
    {
        return Post::with(['images', 'user'])
            ->withCount('comments')
            ->latest()
            ->get();
    }

    /**
     * Summary of getLatestPostPerUser
     *
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
     */
    public function getPostById(int $id): Post
    {
        return Post::with(['images', 'user'])->findOrFail($id);
    }

    public function create(
        int $authorId,
        string $title,
        ?string $content
    ): Post {
        return Post::create([
            'user_id' => $authorId,
            'title' => $title,
            'description' => $content,
        ]);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(Post $post, array $data): Post
    {
        $post->update([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
        ]);

        return $post;
    }

    /**
     * Summary of deletePost
     */
    public function deletePost(Post $post): void
    {
        $post->delete();
    }
}
