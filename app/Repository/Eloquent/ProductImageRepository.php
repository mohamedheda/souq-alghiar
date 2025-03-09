<?php

namespace App\Repository\Eloquent;

use App\Models\ProductImage;
use App\Repository\ProductImageRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ProductImageRepository extends Repository implements ProductImageRepositoryInterface
{
    public function __construct(ProductImage $model)
    {
        parent::__construct($model);
    }
}
