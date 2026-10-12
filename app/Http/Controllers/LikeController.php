<?php

namespace App\Http\Controllers;

use App\Services\LikeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class LikeController extends Controller
{
    public function __construct(
        private LikeService $likeService
    ) {}

    public function index():Response
    {
        $userId = (int) Auth::id();

        $likedPosts = $this->likeService->getLikedPostsByUser($userId);

        return Inertia::render('likes/Index', [
            'likedPosts' => $likedPosts,
        ]);
    }

    public function store(int $postId): RedirectResponse 
    {
        $userId = (int) Auth::id();
        $this->likeService->like($userId, $postId);
        return back();
    }
    public function likedBy(int $postId): JsonResponse
    {
        $likes = $this->likeService->getUsersWhoLikedPost($postId);

        return response()->json([
            'likes' => $likes,
        ]);
    }

    public function destroy(int $postId): RedirectResponse
    {
        $userId = (int) Auth::id();
        $this->likeService->unlike($userId, $postId);
        return back();
    }
}
