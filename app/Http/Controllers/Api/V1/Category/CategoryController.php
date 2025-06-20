<?php

namespace App\Http\Controllers\Api\V1\Category;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Category\CategoryResource;
use App\Http\Traits\Responser;
use App\Repository\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    use Responser;
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository,
    )
    {

    }
    public function index()
    {
        if(\request()->category_id)
            $categories = $this->categoryRepository->getSubCategories(request()->category_id);
        else
            $categories = Cache::rememberForever('categories',fn() => $this->categoryRepository->getCategories());
        return $this->responseSuccess(data: CategoryResource::collection($categories));
    }
}
