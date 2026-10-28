<?php

namespace App\Services;

use App\DTOs\Posts\UpdatePostDTO;
use App\Models\Post;
use App\Repositories\PostImageRepository;
use App\Repositories\PostRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;

class PostService
{
    public function __construct(
        private PostRepository $postRepository,
        private PostImageRepository $postImageRepository,
        private PostImageService $postImageService,
    ) {}

    /**
     * @return Collection<int, Post>
     */
    public function getAllPosts(): Collection
    {
        return $this->postRepository->getAllPosts();
    }

    public function getPostById(int $id): Post
    {
        return $this->postRepository->getPostById($id);
    }

    /**
     * @param  array<int, UploadedFile>  $images
     */
    public function createPost(
        int $authorId,
        string $title,
        ?string $content,
        array $images = [],
    ): Post {
        $post = $this->postRepository->create($authorId, $title, $content);
        foreach ($images as $image) {
            $this->postImageRepository->create($post->id, $image);
        }

        return $post;
    }

    public function updatePost(Post $post, UpdatePostDTO $data): Post
    {
        // Get the IDs of images selected for deletion.
        $deletedImageIds = $data->deletedImageIds;

        // Retrieve the selected images belonging to this post in one query.
        $imagesToDelete = $post->images()
            ->whereIn('id', $deletedImageIds)
            ->get();

        // Make sure all selected images were found and belong to this post.
        if ($imagesToDelete->count() !== count($deletedImageIds)) {
            throw ValidationException::withMessages([
                'deleted_image_ids' => __('posts.invalid_image_selection'),
            ]);
        }
        // Count existing, deleted and new images.
        $existingImages = $post->images()->count();
        $deletedImages = $imagesToDelete->count();
        $newImages = count($data->images);

        // Calculate how many images the post will have after updating.
        $totalImages = $existingImages - $deletedImages + $newImages;

        if ($totalImages < 1 || $totalImages > 20) {
            throw ValidationException::withMessages([
                'images' => __('posts.invalid_image_count'),
            ]);
        }

        // Update the post's title and description.
        $this->postRepository->update($post, [
            'title' => $data->title,
            'description' => $data->description,
        ]);

        // Delete only the selected existing images.
        $this->postImageService->deleteImages($imagesToDelete);

        // Add new images if the user uploaded any.
        foreach ($data->images as $image) {
            $this->postImageRepository->create($post->id, $image);
        }

        // Return the updated post with its current images.
        return $post->load('images');
    }

    /**
     * Summary of deletePost
     */
    public function deletePost(Post $post): void
    {

        $images = $this->postImageService->getImagesForPost($post->id);

        $this->postImageService->deleteImages($images);

        $this->postRepository->deletePost($post);
    }
}
