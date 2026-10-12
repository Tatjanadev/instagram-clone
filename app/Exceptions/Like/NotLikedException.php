<?php

namespace App\Exceptions\Like;

use Exception;
use Illuminate\Http\JsonResponse;

class NotLikedException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'message' => 'You have not submitted a like on this post.'
        ],422);
    }
}
