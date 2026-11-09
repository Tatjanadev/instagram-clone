<?php

namespace App\Services;

use App\Models\PostImage;
use App\Repositories\PostImageRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;
use Intervention\Image\ImageManager;

class PostImageService
{
    public function __construct(
        private PostImageRepository $postImageRepository
    ) {}

    public function getById(int $imageId): ?PostImage
    {
        return $this->postImageRepository->getById($imageId);
    }

    public function updateThumbnailPath(
        PostImage $postImage,
        string $thumbnailPath
    ): void {
        $this->postImageRepository->updateThumbnailPath(
            $postImage,
            $thumbnailPath
        );
    }

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

    public function generateThumbnail(int $imageId): void
    {
        $postImage = $this->getById($imageId);

        if ($postImage === null) {
            return;
        }

        $disk = Storage::disk('public');

        // Make sure the original image still exists.
        if (! $disk->exists($postImage->image_path)) {
            return;
        }

        $manager = ImageManager::usingDriver(Driver::class);

        // Read the original uploaded image.
        $image = $manager->decodePath(
            $disk->path($postImage->image_path)
        );

        $image->scaleDown(width: 300);

        // Convert the resized image to WebP.
        $thumbnail = $image->encodeUsingFormat(
            Format::WEBP,
            quality: 80
        );

        $thumbnailPath = 'posts/thumbnails/'.$postImage->id.'.webp';

        // Save the thumbnail as a new file.
        $disk->put($thumbnailPath, (string) $thumbnail);

        // Save the thumbnail path in the database.
        $this->updateThumbnailPath($postImage, $thumbnailPath);

    }

    /**
     * @return array<int, string>
     */
    public function getUnusedImagePaths(): array
    {
        $disk = Storage::disk('public');

        $storedFiles = $disk->allFiles('posts');

        $images = $this->postImageRepository->getAllImages();

        // Collect the paths that are still being used.
        $usedPaths = [];

        foreach ($images as $image) {
            $usedPaths[] = $image->image_path;

            if ($image->thumbnail_path !== null) {
                $usedPaths[] = $image->thumbnail_path;
            }
        }

        // Find files that exist in storage but not in the database.
        $unusedFiles = array_diff($storedFiles, $usedPaths);

        // Only consider files older than 24 hours.
        $cutoffTime = now()->subDay()->timestamp;

        $oldUnusedFiles = [];

        foreach ($unusedFiles as $file) {
            if ($disk->lastModified($file) < $cutoffTime) {
                $oldUnusedFiles[] = $file;
            }
        }

        return $oldUnusedFiles;
    }

    public function cleanupUnusedImages(): void
    {
        // Find unused files older than 24 hours.
        $unusedFiles = $this->getUnusedImagePaths();

        $disk = Storage::disk('public');

        foreach ($unusedFiles as $file) {

            if ($this->postImageRepository->isImagePathUsed($file)) {
                continue;
            }

            // Make sure the file is still old enough.
            if (! $disk->exists($file) || $disk->lastModified($file) >= now()->subDay()->timestamp) {
                continue;
            }

            // Delete the unused file.
            $disk->delete($file);

            logger()->info('Unused image deleted: '.$file);
        }
    }
}
