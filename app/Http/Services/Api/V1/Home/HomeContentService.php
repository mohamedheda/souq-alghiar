<?php

namespace App\Http\Services\Api\V1\Home;

use App\Http\Resources\V1\CategoryCategoryHomeResource;
use App\Http\Resources\V1\Mark\MarkHomeResource;
use App\Http\Traits\Responser;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\MarkRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class HomeContentService
{
    use Responser;
    public function __construct(
        private readonly MarkRepositoryInterface $markRepository ,
        private readonly CategoryRepositoryInterface $categoryRepository ,
    )
    {

    }
    public function categoriesAndMarks(){
        $data['categories']=Cache::rememberForever('categories_home',function (){
            return CategoryCategoryHomeResource::collection($this->categoryRepository->getHomeCategories());
        });
        $data['marks']=Cache::rememberForever('marks_home',function (){
            return MarkHomeResource::collection($this->markRepository->getHomeMarks());
        });
        return $this->responseSuccess(data: $data);
    }
}
