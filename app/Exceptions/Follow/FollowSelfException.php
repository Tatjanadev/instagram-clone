<?php

namespace App\Exceptions\Follow;

use Exception;
use Illuminate\Http\JsonResponse;

class FollowSelfException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'message' => 'You cannot follow yourself.',
        ], 422);
    }
}
