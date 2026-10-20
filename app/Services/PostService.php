<?php

namespace App\Services;

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
        private PostImageRepository $postImageRepository
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

    /**
     * @param  array<string, mixed>  $data
     */
    public function updatePost(Post $post, array $data): Post
    {
        // Count existing, deleted and new images.
        $existingImages = $post->images()->count();
        $deletedImages = count($data['deleted_image_ids'] ?? []);
        $newImages = count($data['images'] ?? []);

        $totalImages = $existingImages - $deletedImages + $newImages;

        if ($totalImages < 1 || $totalImages > 20) {
            throw ValidationException::withMessages([
                'images' => __('posts.invalid_image_count'),
            ]);
        }

        // Check that every selected image belongs to this post.
        foreach ($data['deleted_image_ids'] ?? [] as $imageId) {
            $post->images()->findOrFail($imageId);
        }

        // Update the post's title and description.
        $this->postRepository->update($post, $data);

        // Delete only the selected existing images.
        foreach ($data['deleted_image_ids'] ?? [] as $imageId) {
            $image = $post->images()->findOrFail($imageId);

            $this->postImageRepository->delete($image);
        }

        // Add new images if the user uploaded any.
        foreach ($data['images'] ?? [] as $image) {
            $this->postImageRepository->create($post->id, $image);
        }

        return $post->load('images');
    }

    public function deletePost(Post $post): void
    {
        foreach ($post->images as $image) {
            $this->postImageRepository->delete($image);
        }

        $this->postRepository->deletePost($post);
    }
}
