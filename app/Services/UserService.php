<?php

namespace App\Services;

use App\DTOs\Users\UpdateUserDTO;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function getUser(int $userId): User
    {
        $user = $this->userRepository->getUser($userId);

        $counts = $this->getProfileCounts($userId);

        // Attach the cached counts to the User model.
        $user->posts_count = $counts['posts_count'];
        $user->followers_count = $counts['followers_count'];
        $user->following_count = $counts['following_count'];

        return $user;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->userRepository->getUsers();
    }

    /**
     * @return Collection<int, User>
     */
    public function getOtherUsers(int $currentUserId): Collection
    {
        return $this->userRepository->getOtherUsers($currentUserId);
    }

    public function getUserByUsername(string $username): User
    {
        $user = $this->userRepository->getUserByUsername($username);

        $counts = $this->getProfileCounts($user->id);

        // Attach the cached counts to the User model.
        $user->posts_count = $counts['posts_count'];
        $user->followers_count = $counts['followers_count'];
        $user->following_count = $counts['following_count'];

        return $user;
    }

    /**
     * Get the cached post, follower, and following counts for a user.
     *
     * @return array{posts_count: int, followers_count: int, following_count: int}
     */
    public function getProfileCounts(int $userId): array
    {
        return Cache::remember(
            "user:{$userId}:profile_counts",
            600,
            fn () => $this->userRepository->getProfileCounts($userId)
        );
    }

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
            $user->email_verified_at = null;
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

        if ($oldProfilePhotoPath) {
            $this->deleteImage($oldProfilePhotoPath);
        }

        return $updatedUser;
    }

    public function delete(User $user): void
    {
        $profilePhotoPath = $user->profile_photo_path ?? null;

        $this->userRepository->delete($user);

        if ($profilePhotoPath) {
            $this->deleteImage($profilePhotoPath);
        }
    }

    private function deleteImage(string $imagePath): void
    {
        if ($imagePath && ! str_starts_with($imagePath, 'demo/avatars/')) {
            Storage::disk('public')->delete($imagePath);
        }
    }
}
