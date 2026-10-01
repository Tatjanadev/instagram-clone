<?php

namespace App\Repositories;

use App\Models\PostImage;
use Illuminate\Http\UploadedFile;

class PostImageRepository
{
    public function create(int $postId, UploadedFile $image): PostImage
    {
        $path = $image->store('posts', 'public');

        return PostImage::create([
            'post_id' => $postId,
            'image_path' => $path,
        ]);
    }
}
