<?php

namespace App\Http\Controllers;

use App\Http\Requests\Posts\StorePostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Models\Post;
use App\Services\CommentService;
use App\Services\PostService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function __construct(
        private PostService $postService,
        private CommentService $commentService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('posts/Index', [
            'posts' => $this->postService->getAllPosts(),
            'currentUserId' => $request->user()->id,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        Gate::authorize('create', Post::class);

        return Inertia::render('posts/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): RedirectResponse
    {
        Gate::authorize('create', Post::class);

        $this->postService->createPost(
            $request->user()->id,
            $request->validated('title'),
            $request->validated('description') ?? null,
            $request->file('images')
        );
        Inertia::flash('toast', [
            'type' => 'success',
            'message' => __('posts.post_created'),
        ]);

        return redirect()
            ->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id): Response
    {
        $post = $this->postService->getPostById((int) $id);

        Gate::authorize('view', $post);

        $comments = $this->commentService->getCommentsForPost($post->id);
        $commentsCount = $comments->count();

        return Inertia::render('posts/Show', [
            'post' => $post,
            'comments' => $comments,
            'commentsCount' => $commentsCount,
            'currentUserId' => $request->user()->id,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): Response
    {
        $post = $this->postRepository->getPostById((int) $id);

        Gate::authorize('update', $post);

        return Inertia::render('posts/Edit', [
            'post' => $post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, string $id): RedirectResponse
    {
        $post = $this->postRepository->getPostById((int) $id);

        Gate::authorize('update', $post);

        $this->postService->updatePost(
            $post,
            $request->validated()
        );
        Inertia::flash('toast', [
            'type' => 'success',
            'message' => __('posts.post_updated'),
        ]);

        return redirect()
            ->route('posts.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $post = $this->postService->getPostById((int) $id);

        Gate::authorize('delete', $post);

        $this->postService->deletePost($post);

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => __('posts.post_deleted'),
        ]);

        return redirect()
            ->route('posts.index');
    }
}
