<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\PostImageRepository;
use App\Repositories\PostRepository;
use Illuminate\Http\UploadedFile;

class PostService
{
    public function __construct(
        private PostRepository $postRepository,
        private PostImageRepository $postImageRepository
    ) {}

    /**
     * @param  array<int, UploadedFile>  $images
     */
    public function createPost(
        int $authorId,
        string $title,
        string $content,
        array $images = [],
    ): Post {
        $post = $this->postRepository->create($authorId, $title, $content);
        foreach ($images as $image) {
            $this->postImageRepository->create($post->id, $image);
        }

        return $post;
    }
}
