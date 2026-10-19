<?php

namespace App\Repositories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

class CommentRepository
{
    public function create(int $userId, int $postId, string $body): Comment
    {
        return Comment::create([
            'user_id' => $userId,
            'post_id' => $postId,
            'body' => $body,
        ]);
    }

    public function update(Comment $comment, string $body): bool
    {
        return $comment->update([
            'body' => $body,
        ]);
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getCommentsForPost(int $postId): Collection
    {
        return Comment::with('user:id,first_name,last_name,username,profile_photo_path')
        ->where('post_id', $postId)
            ->get();
    }

    public function getCommentsCountForPost(int $postId): int
    {
        return Comment::where('post_id', $postId)->count();
    }

    public function delete(Comment $comment): bool
    {
        return $comment->delete() ?? false;
    }
}
