<?php

namespace App\Repository\Eloquent;

use App\Models\CarModel;
use App\Repository\ModelRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ModelRepository extends Repository implements ModelRepositoryInterface
{
    public function __construct(CarModel $model)
    {
        parent::__construct($model);
    }

    public function getModelsByMark($mark_id)
    {
        return $this->model::query()
            ->where('mark_id', $mark_id)
            ->paginate(50);
    }

}
