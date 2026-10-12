<?php

namespace App\Exceptions\Like;

use Exception;
use Illuminate\Http\JsonResponse;

class CannotLikeTwiceException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'message' => 'You have already liked this post.',
        ], 422);
    }
}
