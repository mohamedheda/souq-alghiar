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
    public function getAllMarks(){
        return $this->model::query()
            ->orderBy('name_'.app()->getLocale())
            ->get();
    }
    public function getHomeMarks(){
        return $this->model::query()
            ->orderByDesc('show_home')
            ->orderByDesc('important')
            ->limit(16)
            ->get();
    }


}
