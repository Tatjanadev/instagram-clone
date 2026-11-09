<?php

namespace App\Services;

use App\Exceptions\Comment\CommentDeletionFailedException;
use App\Jobs\CheckCommentForBadWords;
use App\Models\Comment;
use App\Notifications\NewCommentNotification;
use App\Repositories\CommentRepository;
use App\Repositories\PostRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class CommentService
{
    public function __construct(
        private CommentRepository $commentRepository,
        private PostRepository $postRepository,
    ) {}

    public function getById(int $commentId): Comment
    {
        return $this->commentRepository->getById($commentId);
    }

    public function create(int $userId, int $postId, string $body): Comment
    {
        $comment = $this->commentRepository->create($userId, $postId, $body);
        $post = $this->postRepository->get($postId, ['user']);
        if ($post->user_id !== $userId) {
            $post->user->notify(new NewCommentNotification($comment));
        }

        // Check if comment has bad words
        $job = new CheckCommentForBadWords($comment->id);
        dispatch($job);

        return $comment;
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
