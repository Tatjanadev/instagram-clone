<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Storage;
use App\DTOs\Users\UpdateUserDTO;

class UserService
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

  public function update(User $user, UpdateUserDTO $updateUserDTO): User
{
    $data = [
        'first_name' => $updateUserDTO->firstName,
        'last_name' => $updateUserDTO->lastName,
        'username' => $updateUserDTO->username,
        'email' => $updateUserDTO->email,
        'bio' => $updateUserDTO->bio,
        'gender' => $updateUserDTO->gender,
        'date_of_birth' => $updateUserDTO->dateOfBirth,
    ];

    $userEmailIsUpdated = $user->email !== $updateUserDTO->email;

    if ($userEmailIsUpdated) {
        $data['email_verified_at'] = null;
    }

    $oldProfilePhotoPath = null;

    if ($updateUserDTO->profilePhoto) {
        $oldProfilePhotoPath = $user->profile_photo_path;

        $newProfilePhotoPath = $updateUserDTO->profilePhoto->store(
            'avatars',
            'public'
        );

        $data['profile_photo_path'] = $newProfilePhotoPath;
    }

    $updatedUser = $this->userRepository->update($user, $data);

    if (
        $oldProfilePhotoPath &&
        !str_starts_with($oldProfilePhotoPath, 'demo/avatars/')
    ) {
        Storage::disk('public')->delete($oldProfilePhotoPath);
    }

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
