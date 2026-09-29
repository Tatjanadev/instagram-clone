<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * Update the user's profile.
     */
    public function updateUserProfile(User $user, array $data): User
    {
        $user->fill($data);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return $user;
    }

    /**
     * Delete the user's account.
     */
    public function deleteUserAccount(User $user): void
    {
        $user->delete();
    }
}