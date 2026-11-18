<?php

namespace App\Services;

use App\Exceptions\Follow\CannotFollowTwiceException;
use App\Exceptions\Follow\FollowSelfException;
use App\Exceptions\Follow\NotFollowingException;
use App\Models\Follow;
use App\Repositories\FollowRepository;
use Illuminate\Support\Facades\Cache;

class FollowService
{
    public function __construct(
        private FollowRepository $followRepository
    ) {}

    public function follow(int $followerId, int $followingId): Follow
    {
        if ($followerId === $followingId) {
            throw new FollowSelfException;
        }

        if ($this->followRepository->isFollowing($followerId, $followingId)) {
            throw new CannotFollowTwiceException;
        }

        $follow = $this->followRepository->follow($followerId, $followingId);

        // Clear both users' cached profile counts after a successful follow.
        Cache::forget("user:{$followerId}:profile_counts");
        Cache::forget("user:{$followingId}:profile_counts");

        return $follow;
    }

    public function unfollow(int $followerId, int $followingId): void
    {
        if (! $this->followRepository->isFollowing($followerId, $followingId)) {
            throw new NotFollowingException;
        }
        $this->followRepository->unfollow($followerId, $followingId);

        Cache::forget("user:{$followerId}:profile_counts");
        Cache::forget("user:{$followingId}:profile_counts");
    }

    public function isFollowing(int $followerId, int $followingId): bool
    {
        return $this->followRepository->isFollowing($followerId, $followingId);
    }
}
