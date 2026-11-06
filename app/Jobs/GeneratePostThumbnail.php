<?php

namespace App\Jobs;

use App\Services\PostImageService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GeneratePostThumbnail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private int $postImageId) {}

    /**
     * Execute the job.
     */
    public function handle(PostImageService $postImageService): void
    {
        $postImageService->generateThumbNail($this->postImageId);
    }
}
