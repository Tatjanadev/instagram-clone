<?php

namespace App\Exceptions\Follow;

use Exception;
use Illuminate\Http\JsonResponse;

class CannotFollowTwiceException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'message' => __('follows.already_following')
        ], 422);
    }
}
