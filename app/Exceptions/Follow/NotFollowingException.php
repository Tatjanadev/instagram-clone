<?php

namespace App\Exceptions\Follow;

use Exception;
use Illuminate\Http\JsonResponse;

class NotFollowingException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'message' => 'You are not following this user.',
        ], 422);
    }
}
