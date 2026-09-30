<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
      /**
     * Update the user's profile.
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
        return;
    }
}