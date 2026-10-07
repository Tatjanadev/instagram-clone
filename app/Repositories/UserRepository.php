<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

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
     * Get all users for the user list.
     */
    public function getUsers(): Collection
    {
        return User::select(['id', 'first_name', 'last_name', 'username', 'profile_photo_path'])
            ->get();
    }

    /**
     * Get a user by username with their posts, images, and counts.
     */
    public function getUserByUsername(string $username): User
    {
        return User::where('username', $username)
            ->with([
                'posts' => function ($query) {
                    $query->latest()->with('images');
                },
            ])
            ->withCount(['posts', 'followers', 'following'])
            ->firstOrFail();
    }

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
