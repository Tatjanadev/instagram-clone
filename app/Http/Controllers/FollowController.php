<?php

namespace App\Http\Controllers;

use App\Services\FollowService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function __construct(
        private FollowService $followService
    ) {}

    /**
     * Follow a user.
     */
    public function store(int $followingId): RedirectResponse
    {
        $followerId = (int) Auth::id();

        $this->followService->follow($followerId, $followingId);

        return back();
    }

    public function destroy(int $followingId): RedirectResponse
    {
        $followerId = (int) Auth::id();

        $this->followService->unfollow($followerId, $followingId);

        return back();
    }
}
