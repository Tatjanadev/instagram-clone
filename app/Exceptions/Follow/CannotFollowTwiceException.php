<?php

namespace App\Exceptions\Follow;

use Exception;
use Illuminate\Http\JsonResponse;

class CannotFollowTwiceException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'message' => 'You are already following this user.',
        ], 422);
    }
}
