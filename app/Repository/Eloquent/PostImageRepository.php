<?php

namespace App\Repository\Eloquent;

use App\Models\PostImage;
use App\Repository\PostImageRepositoryInterface;

class PostImageRepository extends Repository implements PostImageRepositoryInterface
{
    public function __construct(PostImage $model)
    {
        parent::__construct($model);
    }
}
