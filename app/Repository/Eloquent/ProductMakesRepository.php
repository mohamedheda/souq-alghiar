<?php

namespace App\Repository\Eloquent;

use App\Models\ProductMark;
use App\Repository\ProductMakesRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ProductMakesRepository extends Repository implements ProductMakesRepositoryInterface
{
    public function __construct(ProductMark $model)
    {
        parent::__construct($model);
    }
}
