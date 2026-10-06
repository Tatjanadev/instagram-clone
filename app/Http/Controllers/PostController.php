<?php

namespace App\Http\Controllers;

use App\Http\Requests\Posts\StorePostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('posts/Index', [
            'posts' => $this->postRepository->getAllPosts(),
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

        $this->postRepository->createPost(
            $request->user()->id,
            $request->validated(),
            $request->file('images')
        );

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id): Response
    {
        $post = $this->postRepository->getPostById((int) $id);

        Gate::authorize('view', $post);

        return Inertia::render('posts/Show', [
            'post' => $post,
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

        $this->postRepository->updatePost(
            $post,
            $request->validated()
        );
        Inertia::flash('toast', [
            'type' => 'success',
            'message' => __('Your post has been edited successfully.'),
        ]);

        return redirect()
            ->route('posts.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $post = $this->postRepository->getPostById((int) $id);

        Gate::authorize('delete', $post);

        $this->postRepository->deletePost($post);

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => __('Your post has been deleted successfully.'),
        ]);

        return redirect()
            ->route('posts.index');
    }
}
