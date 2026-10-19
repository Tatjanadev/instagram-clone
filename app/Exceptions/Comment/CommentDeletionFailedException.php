<?php

namespace App\Exceptions\Comment;

use Exception;

class CommentDeletionFailedException extends Exception
{
    public function __construct()
    {
        parent::__construct(__('comments.cannot_delete'));
    }
}