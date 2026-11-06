<?php

namespace App\Repositories;

use App\Models\PostImage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PostImageRepository
{
    public function getById(int $imageId): ?PostImage
    {
        return PostImage::find($imageId);
    }

    public function updateThumbnailPath(
        PostImage $postImage,
        string $thumbnailPath
    ): void {
        $postImage->update([
            'thumbnail_path' => $thumbnailPath,
        ]);
    }

    /**
     * @return Collection<int, PostImage>
     */
    public function getImagesForPost(int $postId): Collection
    {
        return PostImage::where('post_id', $postId)->get();
    }

    public function create(int $postId, UploadedFile $image): PostImage
    {
        $path = $image->store('posts', 'public');

        return PostImage::create([
            'post_id' => $postId,
            'image_path' => $path,
        ]);
    }

    public function delete(PostImage $image): void
    {
        // Delete the physical file only if it is a real user upload.
        if (str_starts_with($image->image_path, 'posts/')) {
            Storage::disk('public')->delete($image->image_path);
        }

        // Delete the generated thumbnail, if one exists.
        if ($image->thumbnail_path !== null) {
            Storage::disk('public')->delete($image->thumbnail_path);
        }

        $image->delete();
    }
}
