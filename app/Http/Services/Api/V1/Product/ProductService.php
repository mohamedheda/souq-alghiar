<?php

namespace App\Http\Services\Api\V1\Product;

use App\Http\Resources\V1\Product\ProductDetailsResource;
use App\Http\Services\Mutual\FileManagerService;
use App\Http\Traits\Responser;
use App\Repository\Eloquent\ProductImageRepository;
use App\Repository\Eloquent\UserRepository;
use App\Repository\InfoRepositoryInterface;
use App\Repository\ProductImageRepositoryInterface;
use App\Repository\ProductMakesRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ProductService
{
    use Responser;

    const SPECIFIC_MAKES = 0;

    public function __construct(
        private readonly FileManagerService              $fileManagerService,
        private readonly ProductRepositoryInterface      $productRepository,
        private readonly ProductImageRepositoryInterface $productImageRepository,
        private readonly ProductHelperService $helperService ,
    )
    {

    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $response = Gate::inspect('add-product', [$request->featured]);
            if ($response->allowed()) {
                $data = $request->except(['images', 'makes']);
                $data['user_id'] = auth('api')->id();
                $product = $this->productRepository->create($data);
                if (filter_var(app(InfoRepositoryInterface::class)->getValue('withdraw_points_enabled'), FILTER_VALIDATE_BOOLEAN))
                    $this->helperService->withdrawPoints($request->featured);
                if ($request->images && is_array($request->images))
                    $this->helperService->attachImages($request->images, $product);
                if ($request->makes && is_array($request->makes) && $request->all_makes == self::SPECIFIC_MAKES)
                    $this->helperService->attachMakes($request->makes, $product);
            } else {
                return $this->responseFail(message: $response->message());
            }
            DB::commit();
            return $this->responseSuccess(message: __('messages.created successfully'));
        } catch (Exception $e) {
            DB::rollBack();
//            return $e;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function update($id, $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->except(['images', 'makes', 'deleted_makes', 'deleted_images']);
            $this->productRepository->update($id, $data);

            $product = $this->productRepository->getById($id);

            if ($request->images && is_array($request->images))
                $this->helperService->attachImages($request->images, $product);
            if ($request->makes && is_array($request->makes) && $request->all_makes == self::SPECIFIC_MAKES)
                $this->helperService->attachMakes($request->makes, $product);
            if ($request->deleted_makes && is_array($request->deleted_makes))
                $this->helperService->deleteMakes($request->deleted_makes);
            if ($request->deleted_images && is_array($request->deleted_images))
                $this->helperService->deleteImages($request->deleted_images);

            DB::commit();
            return $this->responseSuccess(message: __('messages.updated successfully'));
        } catch (Exception $e) {
            DB::rollBack();
//            return $e;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }



    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $product = $this->productRepository->getById($id);
            $deleted_makes = $product->markes()?->pluck('id');
            $deleted_images = $product->images()?->pluck('id');
            if (!empty($deleted_makes))
                $this->helperService->deleteMakes($deleted_makes);
            if (!empty($deleted_images))
                $this->helperService->deleteImages($deleted_images);
            $this->productRepository->delete($id);
            DB::commit();
            return $this->responseSuccess(message: __('messages.deleted successfully'));
        } catch (Exception $e) {
            DB::rollBack();
//            return $e;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
    public function show($id){
        try {
            $product = $this->productRepository->getById($id,relations:['images','category:id,name_ar,name_en','markes','markes.make:id,name_ar,name_en,logo','markes.model:id,name_ar,name_en']);
            $product->labels=$this->helperService->prepareLabels($product);
//            return $product;
            DB::commit();
            return $this->responseSuccess(data: ProductDetailsResource::make($product));
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
}
