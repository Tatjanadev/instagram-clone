<?php

namespace App\Services;

use App\Exceptions\Like\CannotLikeTwiceException;
use App\Exceptions\Like\NotLikedException;
use App\Models\Like;
use App\Repositories\LikeRepository;
use Illuminate\Database\Eloquent\Collection;

class LikeService
{
    public function __construct(
        private LikeRepository $likeRepository
    ) {}

    public function like(int $userId, int $postId): Like
    {
        if ($this->likeRepository->isLikedByUser($userId, $postId)) {
            throw new CannotLikeTwiceException(
                $this->getLikesCountForPost($postId)
            );
        }

        return $this->likeRepository->like($userId, $postId);
    }

    public function unlike(int $userId, int $postId): void
    {
        if (! $this->likeRepository->isLikedByUser($userId, $postId)) {
            throw new NotLikedException(
                $this->getLikesCountForPost($postId)
            );
        }
        $this->likeRepository->unlike($userId, $postId);
    }

    public function isLikedByUser(int $userId, int $postId): bool
    {
        return $this->likeRepository->isLikedByUser($userId, $postId);
    }

    /**
     * @return Collection<int, Like>
     */
    public function getLikedPostsByUser(int $userId): Collection
    {
        return $this->likeRepository->getLikedPostsByUser($userId);
    }

    public function getLikesCountForPost(int $postId): int
    {
        return $this->likeRepository->getLikesCountForPost($postId);
    }

    /**
     * @return Collection<int, Like>
     */
    public function getUsersWhoLikedPost(int $postId): Collection
    {
        return $this->likeRepository->getUsersWhoLikedPost($postId);
    }
}
