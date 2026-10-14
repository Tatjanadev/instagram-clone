<?php

namespace App\Exceptions\Like;

use Exception;
use Illuminate\Http\JsonResponse;

class CannotLikeTwiceException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'message' => __('likes.already_liked')
        ], 422);
    }
}
