<?php

namespace App\Exceptions\Like;

use Exception;
use Illuminate\Http\JsonResponse;

class NotLikedException extends Exception
{
    public function __construct(
        private int $likesCount
    ) {
        parent::__construct();
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'message' => __('likes.no_like'),
            'already_unliked' => true,
            'likes_count' => $this->likesCount,
        ], 422);
    }
}
