<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comments\StoreCommentRequest;
use App\Http\Requests\Comments\UpdateCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class CommentController extends Controller
{
    public function __construct(
        private CommentService $commentService
    ) {}

    public function index(Post $post): JsonResponse
    {
        Gate::authorize('view', $post);

        $comments = $this->commentService->getCommentsForPost($post->id);

        return response()->json([
            'comments' => $comments,
        ]);
    }

    public function store(StoreCommentRequest $request, Post $post): RedirectResponse
    {
        Gate::authorize('create', Comment::class);

        $this->commentService->create(
            $request->user()->id,
            $post->id,
            $request->validated('body')
        );
        Inertia::flash('toast', [
            'type' => 'success',
            'message' => __('comments.comment_created'),
        ]);

        return back();
    }

    public function update(UpdateCommentRequest $request, Comment $comment): RedirectResponse
    {
        Gate::authorize('update', $comment);

        $this->commentService->update(
            $comment,
            $request->validated('body')
        );
        Inertia::flash('toast', [
            'type' => 'success',
            'message' => __('comments.comment_updated'),
        ]);

        return back();
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        Gate::authorize('delete', $comment);

        $this->commentService->delete($comment);

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => __('comments.comment_deleted'),
        ]);

        return back();
    }
}
