<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function update(User $user, array $data): User
    {
        $userEmailIsUpdated = $user->email !== $data['email'] ?? null;
        if ($userEmailIsUpdated) {
            $data['email_verified_at'] = null;
        }

        $updatedUser = $this->userRepository->update($user, $data);

        return $updatedUser;
    }

    public function delete(User $user): void
    {
        $profilePhotoPath = $user->profile_photo_path ?? null;

        $this->userRepository->delete($user);

        if ($profilePhotoPath && ! str_starts_with($profilePhotoPath, 'demo/avatars/')
        ) {
            Storage::disk('public')->delete($profilePhotoPath);
        }
    }
}
