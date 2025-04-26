<?php

namespace App\Repository\Eloquent;

use App\Models\Product;
use App\Repository\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ProductRepository extends Repository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }
    public function cursorProducts($per_page,$relations=[]){
        $query= $this->model::query();
        return $query->with($relations)->latest('updated_at')->cursorPaginate($per_page,cursorName: 'page');
    }
}
