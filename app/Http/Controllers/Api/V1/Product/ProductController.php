<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Product\ProductRequest;
use App\Http\Requests\Api\V1\Product\UpdateProductRequest;
use App\Http\Services\Api\V1\Product\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService)
    {

    }
    public function index(Request $request){
        return $this->productService->index($request);
    }
    public function store(ProductRequest $request)
    {
        return $this->productService->store($request);
    }

    public function update($id, UpdateProductRequest $request)
    {
        return $this->productService->update($id, $request);
    }
    public function delete($id)
    {
        return $this->productService->delete($id);
    }
    public function show($id)
    {
        return $this->productService->show($id);
    }
}
