<?php

namespace App\Http\Services\Api\V1\Product;

use App\Http\Services\Mutual\FileManagerService;
use App\Http\Traits\Responser;
use App\Repository\Eloquent\UserRepository;
use App\Repository\InfoRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ProductService
{
    use Responser;

    const SPECIFIC_MAKES = 0;

    public function __construct(
        private readonly FileManagerService         $fileManagerService,
        private readonly ProductRepositoryInterface $productRepository,
        private readonly UserRepository             $userRepository,
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
                    $this->withdrawPoints($request->featured);
                if ($request->images && is_array($request->images))
                    $this->attachImages($request->images, $product);
                if ($request->makes && is_array($request->makes) && $request->all_makes == self::SPECIFIC_MAKES)
                    $this->attachMakes($request->makes, $product);
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

    private function attachImages($images, $product)
    {
        $saved_image_paths = [];
        foreach ($images as $image) {
            $saved_image_paths[] = ['image' => $this->fileManagerService->uploadFile($image, 'products')];
        }
        $product->images()?->createMany($saved_image_paths);
    }

    private function attachMakes($makes, $product)
    {
        $product->markes()?->createMany(array_values($makes));
    }

    private function withdrawPoints($featured)
    {
        $points_amount = $featured ?
            app(InfoRepositoryInterface::class)->getValue('featured_product_points') :
            app(InfoRepositoryInterface::class)->getValue('product_addition_points');
        $this->userRepository->decrementValue('wallet', $points_amount
            , auth('api')->id());
        // TODO : Save logs for wallets .
    }
}
