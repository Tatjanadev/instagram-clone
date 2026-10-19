<?php

namespace App\Services;

use App\Models\Comment;
use App\Repositories\CommentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;
use App\Exceptions\Comment\CommentDeletionFailedException;
class CommentService
{
    public function __construct(
        private CommentRepository $commentRepository
    ) {}

    public function create(int $userId, int $postId, string $body): Comment
    {
        return $this->commentRepository->create($userId, $postId, $body);
    }

    public function update(Comment $comment, string $body): bool
    {
        if ($comment->body === $body) {
            throw ValidationException::withMessages([
                'body' => __('comments.not_changed'),
            ]);
        }

        return $this->commentRepository->update($comment, $body);
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getCommentsForPost(int $postId): Collection
    {
        return $this->commentRepository->getCommentsForPost($postId);
    }

    public function getCommentsCountForPost(int $postId): int
    {
        return $this->commentRepository->getCommentsCountForPost($postId);
    }

    public function delete(Comment $comment): void
    {
         if (! $this->commentRepository->delete($comment)) {
        throw new CommentDeletionFailedException;
    }
    }
}
