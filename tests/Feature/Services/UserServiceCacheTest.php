<?php

use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Cache;

it('caches profile counts when they are requested', function () {
    $user = User::factory()->create();

    // Make sure the user's profile counts are not cached yet.
    $cacheKey = "user:{$user->id}:profile_counts";
    Cache::forget($cacheKey);

    $counts = app(UserService::class)->getProfileCounts($user->id);

    // A new user should have zero posts, followers and following.
    expect($counts)->toBe([
        'posts_count' => 0,
        'followers_count' => 0,
        'following_count' => 0,
    ]);

    // Verify that the counts have been stored in the cache.
    expect(Cache::get($cacheKey))->toBe($counts);
});

it('returns cached profile counts without querying the repository again', function () {
    $user = User::factory()->create();

    $cacheKey = "user:{$user->id}:profile_counts";

    $counts = [
        'posts_count' => 5,
        'followers_count' => 10,
        'following_count' => 3,
    ];

    Cache::put($cacheKey, $counts, 600);

    $result = app(UserService::class)->getProfileCounts($user->id);

    expect($result)->toBe($counts);
});
