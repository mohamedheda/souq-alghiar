<?php

namespace App\Http\Services\Api\V1\Home;

use App\Http\Resources\V1\CategoryCategoryHomeResource;
use App\Http\Resources\V1\Mark\MarkHomeResource;
use App\Http\Resources\V1\Post\PostResource;
use App\Http\Resources\V1\Product\ProductResource;
use App\Http\Traits\Responser;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\MarkRepositoryInterface;
use App\Repository\PostRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class HomeContentService
{
    use Responser;
    public function __construct(
        private readonly MarkRepositoryInterface $markRepository ,
        private readonly CategoryRepositoryInterface $categoryRepository ,
        private readonly PostRepositoryInterface $postRepository ,
        private readonly ProductRepositoryInterface $productRepository ,

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
    public function postsAndProducts(){
        $data['posts_home']=Cache::remember('posts_home',60 * 12,function (){
            return PostResource::collection($this->postRepository->getHomePosts(relations:['user:id,name,image', 'mark:id,logo', 'category:id,name_ar,name_en', 'city:id,name_ar,name_en'] ));
        });
        $data['products_home_featured']=Cache::remember('products_home_featured',60 * 12,function (){
            return ProductResource::collection($this->productRepository->getHomeFeaturedProducts( relations: ['mainImage', 'markes.make', 'user']));
        });
        $data['products_home_most_viewed']=Cache::remember('products_home_most_viewed',60 * 12,function (){
            return ProductResource::collection($this->productRepository->getHomeMostViewedProducts( relations: ['mainImage', 'markes.make', 'user']));
        });
        $data['products_home_latest']=  ProductResource::collection($this->productRepository->getHomeLatestProducts( relations: ['mainImage', 'markes.make', 'user']));
        return $this->responseSuccess(data: $data);
    }
}
