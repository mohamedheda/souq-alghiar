<?php

namespace App\Repository\Eloquent;

use App\Models\City;
use App\Repository\CityRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class CityRepository extends Repository implements CityRepositoryInterface
{
    public function __construct(City $model)
    {
        parent::__construct($model);
    }

    public function getCities()
    {
        return $this->model::query()->orderBy('name_' . app()->getLocale())->get();
    }
}
