<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Post;

class ProfileRepository
{
    public function updateProfile(User $user, array $data): User
    {
        $user->fill($data);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return $user;
    }

    public function deleteProfile(User $user): void
    {
        $user->delete();
    }
}