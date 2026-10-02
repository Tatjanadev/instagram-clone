<?php

namespace App\DTOs\Users;

use Illuminate\Http\UploadedFile;

class UpdateUserDTO
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $username,
        public string $email,
        public ?UploadedFile $profilePhoto = null,
        public ?string $bio = null,
        public ?string $gender = null,
        public ?string $dateOfBirth = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            firstName: $data['first_name'],
            lastName: $data['last_name'],
            username: $data['username'],
            email: $data['email'],
            profilePhoto: $data['profile_photo'] ?? null,
            bio: $data['bio'] ?? null,
            gender: $data['gender'] ?? null,
            dateOfBirth: $data['date_of_birth'] ?? null,
        );
    }
}
