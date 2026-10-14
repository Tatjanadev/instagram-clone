<?php

namespace App\Exceptions\Follow;

use Exception;
use Illuminate\Http\JsonResponse;

class NotFollowingException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'message' => __('follows.not_following'),
        ], 422);
    }
}
