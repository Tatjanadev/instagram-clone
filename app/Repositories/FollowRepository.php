<?php

namespace App\Repositories;

use App\Models\Follow;

class FollowRepository
{
    /**
     * Summary of follow
     */
    public function follow(int $followerId, int $followingId): Follow
    {
        return Follow::create([
            'follower_id' => $followerId,
            'following_id' => $followingId,
        ]);
    }

    public function unfollow(int $followerId, int $followingId): void
    {
        Follow::where('follower_id', $followerId)
            ->where('following_id', $followingId)
            ->delete();
    }

    public function isFollowing(int $followerId, int $followingId): bool
    {
        return Follow::where('follower_id', $followerId)
            ->where('following_id', $followingId)
            ->exists();
    }
}
