<?php

namespace App\Http\Controllers\Dashboard\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Product\ProductRequest;
use App\Http\Requests\Dashboard\Product\ProductWithCodeRequest;
use App\Http\Services\Dashboard\Merchant\MerchantService;
use Illuminate\Http\Request;

class MerchantController extends Controller
{


    public function __construct(private MerchantService $merchantService)
    {

    }
    public function index(){
        return $this->merchantService->index();
    }
    public function store(ProductRequest $request){
        return $this->merchantService->store($request);
    }
    public function storeWithCode(ProductWithCodeRequest $request){
        return $this->merchantService->storeWithCode($request);
    }
    public function create($id){
        return $this->merchantService->create($id);
    }
    public function createWithCode($id){
        return $this->merchantService->createWithCode($id);
    }
    public function merchantsProducts($id){
        return $this->merchantService->merchantsProducts($id);
    }
}
