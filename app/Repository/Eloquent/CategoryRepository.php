<?php

namespace App\Repository\Eloquent;

use App\Models\Category;
use App\Repository\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class CategoryRepository extends Repository implements CategoryRepositoryInterface
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }
    public function paginteCategories($paginate){
        return $this->model::query()
                ->whereNull('parent_id')
                ->paginate($paginate);
    }
    public function getCategories($relations=[]){
        return $this->model::query()
            ->whereNull('parent_id')
            ->with($relations)
            ->get();
    }
    public function getSubCategories($parent_id){
        return $this->model::query()
            ->where('parent_id',$parent_id)
            ->get();
    }
    public function getHomeCategories(){
        return $this->model::query()
            ->orderByDesc('show_home')
            ->limit(8)
            ->oldest()
            ->get();
    }


}
