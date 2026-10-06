<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * Get the user with their posts, images, and counts.
     */
    public function getUser(int $userId): User
    {
        return User::where('id', $userId)
            ->with([
                'posts' => function ($query) {
                    $query->latest()->with('images');
                },
            ])
            ->withCount(['posts', 'followers', 'following'])
            ->firstOrFail();
    }

    /**
     * Update the user's profile.
     */
    /**
     * @param  array<string, mixed>  $data
     */
    public function update(User $user, array $data): User
    {
        $user->fill($data);
        $user->save();

        return $user;
    }

    /**
     * Delete the user's account.
     */
    public function delete(User $user): void
    {
        $user->delete();

    }
}
