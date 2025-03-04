<?php

namespace App\Repository\Eloquent;

use App\Models\Mark;
use App\Repository\MarkRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class MarkRepository extends Repository implements MarkRepositoryInterface
{
    public function __construct(Mark $model)
    {
        parent::__construct($model);
    }
}
