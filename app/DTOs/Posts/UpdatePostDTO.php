<?php

namespace App\DTOs\Posts;

use Illuminate\Http\UploadedFile;

readonly class UpdatePostDTO
{
    /**
     * @param  array<int, UploadedFile>  $images
     * @param  array<int, int>  $deletedImageIds
     */
    public function __construct(
        public string $title,
        public ?string $description,
        public array $images = [],
        public array $deletedImageIds = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            description: $data['description'] ?? null,
            images: $data['images'] ?? [],
            deletedImageIds: $data['deleted_image_ids'] ?? [],
        );
    }
}
