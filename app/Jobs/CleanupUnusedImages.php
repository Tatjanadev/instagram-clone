<?php

namespace App\Jobs;

use App\Services\PostImageService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CleanupUnusedImages implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(PostImageService $postImageService): void
    {
      $postImageService->cleanupUnusedImages();
    }
}
