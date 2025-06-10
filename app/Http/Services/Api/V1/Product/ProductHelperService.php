<?php

namespace App\Http\Services\Api\V1\Product;

use App\Http\Services\Api\V1\Sphinx\SphinxService;
use App\Http\Services\Mutual\FileManagerService;
use App\Repository\Eloquent\UserRepository;
use App\Repository\InfoRepositoryInterface;
use App\Repository\ProductImageRepositoryInterface;
use App\Repository\ProductMakesRepositoryInterface;

class ProductHelperService
{
    public function __construct(
        private readonly FileManagerService              $fileManagerService,
        private readonly UserRepository                  $userRepository,
        private readonly ProductMakesRepositoryInterface $productMakesRepository,
        private readonly ProductImageRepositoryInterface $productImageRepository,
        private readonly SphinxService $sphinxService ,
    )
    {

    }

    public function deleteMakes($makes)
    {
        $this->productMakesRepository->deleteWhereIn('id', $makes);
    }

    public function deleteImages($images)
    {
        $this->productImageRepository->deleteWhereIn('id', $images);
    }

    public function attachImages($images, $product)
    {
        $saved_image_paths = [];
        foreach ($images as $image) {
            $saved_image_paths[] = ['image' => $this->fileManagerService->uploadFile($image, 'products')];
        }
        $product->images()?->createMany($saved_image_paths);
    }

    public function attachMakes($makes, $product)
    {
        $product->markes()?->createMany(array_values($makes));
    }

    public function withdrawPoints($featured)
    {
        $points_amount = $featured ?
            app(InfoRepositoryInterface::class)->getValue('featured_product_points') :
            app(InfoRepositoryInterface::class)->getValue('product_addition_points');
        $this->userRepository->decrementValue('wallet', $points_amount
            , auth('api')->id());
        // TODO : Save logs for wallets .
    }

    public function prepareLabels($product)
    {
        $labels = [];
        $labels[] = $product->used ? __('messages.New') : __('messages.Used');
        if ($product->category_id)
            $labels[] = $product->category->t('name');
        if ($product->all_makes)
            $labels[] = __('messages.all_makes');
        return $labels;
    }



    public function filterProductsUsingSphinx($request){
        $query="";
        if ($request->key){
            $key=addslashes($request->key);
            $query.="@(title,description) $key";
        }
        $filters = [];
        if ($request->category_id) {
            $filters['category_id'] = (int) $request->category_id;
        }
        if ($request->sub_category_id) {
            $filters['sub_category_id'] = (int) $request->sub_category_id;
        }
        if ($request->city_id) {
            $filters['city_id'] = (int) $request->city_id;
        }
        if ($request->mark_id) {
            $filters['mark_id'] = (int) $request->mark_id;
        }
        if ($request->model_id) {
            $filters['model_id'] = (int) $request->model_id;
        }
        $range_query=null;
        if ($request->year){
            $year = (int) $request->year;
            $range_query= " AND year_from <= $year AND year_to >= $year;";
        }


        $data= $this->sphinxService->search('products_index',$query , $filters,$range_query);
        return $data;
    }
}
