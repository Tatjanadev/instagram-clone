<?php

namespace App\Repositories;

use App\Models\Like;
use Illuminate\Database\Eloquent\Collection;

class LikeRepository
{
    public function like(int $userId, int $postId): Like
    {
        return Like::create([
            'user_id' => $userId,
            'post_id' => $postId,
        ]);
    }

    public function unlike(int $userId, int $postId): void
    {
        Like::where([
            'user_id' => $userId,
            'post_id' => $postId,
        ])->delete();
    }

    public function isLikedByUser(int $userId, int $postId): bool
    {
        return Like::where('user_id', $userId)
            ->where('post_id', $postId)
            ->exists();
    }

    /**
     * @return Collection<int, Like>
     */
    public function getLikedPostsByUser(int $userId): Collection
    {
        return Like::where('user_id', $userId)
            ->with([
                'post' => fn ($query) => $query->withCount('likes'),
                'post.images',
                'post.user',
            ])
            ->latest()
            ->get();
    }

    public function getLikesCountForPost(int $postId): int
    {
        return Like::where('post_id', $postId)->count();
    }

    /**
     * Summary of getUsersWhoLikedPost
     *
     * @return Collection<int, Like>
     */
    public function getUsersWhoLikedPost(int $postId): Collection
    {
        return Like::where('post_id', $postId)
            ->with('user:id,username,first_name,last_name,profile_photo_path')
            ->get();
    }
}
