<?php

namespace App\Exceptions\Like;

use Exception;
use Illuminate\Http\JsonResponse;

class CannotLikeTwiceException extends Exception
{
    public function __construct(
        private int $likesCount
    ) {
        parent::__construct();
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'message' => __('likes.already_liked'),
            'already_liked' => true,
            'likes_count' => $this->likesCount,
        ], 422);
    }
}
