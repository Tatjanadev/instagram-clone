<?php

namespace App\Services;

use App\Models\PostImage;
use App\Repositories\PostImageRepository;
use Illuminate\Support\Collection;

class PostImageService
{
    public function __construct(
        private PostImageRepository $postImageRepository
    ) {}

    /**
     * @return Collection<int, PostImage>
     */
    public function getImagesForPost(int $postId): Collection
    {
        return $this->postImageRepository->getImagesForPost($postId);
    }

    /**
     * Delete the selected post images.
     *
     * @param  Collection<int, PostImage>  $images
     */
    public function deleteImages(Collection $images): void
    {
        foreach ($images as $image) {
            $this->postImageRepository->delete($image);
        }
    }
}
