<?php

namespace App\Repository\Eloquent;

use App\Models\Comment;
use App\Repository\CommentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class CommentRepository extends Repository implements CommentRepositoryInterface
{
    public function __construct(Comment $model)
    {
        parent::__construct($model);
    }
}
