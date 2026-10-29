<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class PostRepository
{
    /**
     * @return Collection<int, Post>
     */
    public function getAllPosts(): Collection
    {
        $userId = (int) Auth::id();

        return Post::with(['images', 'user'])
            ->withCount(['comments', 'likes'])
            ->withExists([
                'likes as is_liked' => fn ($query) => $query->where('user_id', $userId),
            ])
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
            ->withCount('likes')
            ->withExists([
                'likes as is_liked' => fn ($query) => $query->where('user_id', $currentUserId),
            ])
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
        $userId = (int) Auth::id();

        return Post::with(['images', 'user'])
            ->withCount(['comments', 'likes'])
            ->withExists([
                'likes as is_liked' => fn ($query) => $query->where('user_id', $userId),
            ])
            ->findOrFail($id);
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
