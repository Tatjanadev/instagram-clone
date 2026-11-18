<?php

use App\Models\User;
use App\Services\FollowService;
use Illuminate\Support\Facades\Cache;

it('clears both users cached profile counts after following', function () {
    $follower = User::factory()->create();

    $following = User::factory()->create();

    $counts = [
        'posts_count' => 0,
        'followers_count' => 0,
        'following_count' => 0,
    ];

    $followerCacheKey = "user:{$follower->id}:profile_counts";

    $followingCacheKey = "user:{$following->id}:profile_counts";

    Cache::put($followerCacheKey, $counts, 600);
    Cache::put($followingCacheKey, $counts, 600);

    expect(Cache::has($followerCacheKey))->toBeTrue();
    expect(Cache::has($followingCacheKey))->toBeTrue();

    app(FollowService::class)->follow($follower->id, $following->id);

    // Verify both cache entries have been cleared.
    expect(Cache::has($followerCacheKey))->toBeFalse();
    expect(Cache::has($followingCacheKey))->toBeFalse();

});
