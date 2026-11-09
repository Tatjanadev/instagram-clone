<?php

namespace App\Jobs;

use App\Services\CommentService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Str;

class CheckCommentForBadWords implements ShouldQueue
{
    use Queueable;

    /** @var array<int, string> */
    private static $badWords = [
        'kuce',
        'yabalio',
        'bitch',
    ];

    /**
     * Create a new job instance.
     */
    public function __construct(private int $commentId) {}

    /**
     * Execute the job.
     */
    public function handle(
        CommentService $service,
    ): void {
        $comment = $service->getById($this->commentId);
        $hasBadWords = Str::contains(Str::lower($comment->body),
            self::$badWords);
        if (! $hasBadWords) {
            return;
        }

        // Delete comment
        $service->delete($comment);
    }
}
