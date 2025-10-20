<?php

namespace App\Http\Services\Dashboard\Merchant;

use App\Http\Requests\Dashboard\Product\ProductRequest;
use App\Http\Requests\Dashboard\Product\ProductWithCodeRequest;
use App\Http\Services\Api\V1\Product\ProductHelperService;
use App\Repository\Eloquent\CategoryRepository;
use App\Repository\MarkRepositoryInterface;
use App\Repository\ProductMakesRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Gemini\Laravel\Facades\Gemini;

class MerchantService
{
    const SPECIFIC_MAKES = 0;

    public function __construct(
        private readonly UserRepositoryInterface $userRepository ,
        private readonly ProductRepositoryInterface $productRepository ,
        private readonly CategoryRepository $categoryRepository ,
        private readonly MarkRepositoryInterface $markRepository ,
        private readonly ProductHelperService            $helperService,

    )
    {

    }
    public function index(){
        $users = $this->userRepository->paginateMerchants(25);
        return view('dashboard.site.merchants.index', compact('users'));
    }

    public function store(ProductRequest $request){
        DB::beginTransaction();
        $user=$this->userRepository->getById($request->user_id);
        if(!$user->canAddProduct)
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('dashboard.not_subscribed'));
        try {
            $data = $request->except(['images', 'makes']);
            $product = $this->productRepository->create($data);

            if ($request->has('images') && is_array($request->images)) {
                $this->helperService->attachImages($request->images, $product);
            }
            if (
                $request->has('makes') &&
                is_array($request->makes) &&
                $request->all_makes == self::SPECIFIC_MAKES
            ) {
                $this->helperService->attachMakes($request->makes, $product);
            }
            $this->helperService->decreaseProductsCount($request->featured,$user);
            DB::commit();
            return redirect()
                ->route('merchants.products',$request->user_id)
                ->with('success', __('messages.created successfully'));
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('messages.Something went wrong'));
        }
    }
    public function storeWithCode(ProductWithCodeRequest $request){
        DB::beginTransaction();
        $user=$this->userRepository->getById($request->user_id);
        if(!$user->canAddProduct)
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('dashboard.not_subscribed'));
        try {

            $categories=$this->categoryRepository->getCategories(['subCategories']);
            $main_data=json_decode($request->code)[0];
            $vehicle_data=json_decode($request->vehicle_data);
            $title = $main_data?->attributes?->name ?? '';
            $manufacturer = $main_data?->attributes?->manufacturer ?? '';
            $attr_text = collect($main_data?->attributes?->attributes?->criteria ?? []);
            $prompt = <<<PROMPT
            You are an automotive product AI assistant.

            Task:
            1. Read the product details below.
            2. Choose the most relevant category_id and sub_category_id from this list:
            $categories
            3. Generate an Arabic product title and Arabic description suitable for e-commerce.

            Product details:
            Title: $title
            Manufacturer: $manufacturer
            Attributes: $attr_text

            Return JSON in this exact format:
            {
              "category_id": <number>,
              "sub_category_id": <number or null>,
              "title_ar": "<Arabic title>",
              "description_ar": "<Arabic description>"
            }
            PROMPT;

            // Send to Gemini
            $result = Gemini::generativeModel('gemini-2.0-flash')->generateContent($prompt);
            $text = $result->text();
            preg_match('/\{.*\}/s', $text, $matches);

            if (!empty($matches)) {
                $ai_data = json_decode($matches[0], true);
            } else {
                $ai_data = null;
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', __('messages.Something went wrong'));
            }
            $product=[
                'category_id' => $ai_data['category_id'] ,
                'sub_category_id' => $ai_data['sub_category_id'] ,
                'title' => $ai_data['title_ar'] ,
                'description' => $ai_data['description_ar'] ,
                'price' => $request->price ,
                'user_id' => $request->user_id ,
                "all_makes" => $main_data?->attributes?->universal_product == 1 ?1:0 ,
            ];
            $product=$this->productRepository->create($product);
            $this->helperService->attachImagesT($product,$main_data?->attributes->gallery);
            $this->helperService->attachMakesT($product->id,$vehicle_data);
            DB::commit();
            return redirect()
                ->route('merchants.products',$request->user_id)
                ->with('success', __('messages.created successfully'));
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('messages.Something went wrong'));
        }
    }
    public function create($id){
        $categories=$this->categoryRepository->getCategories();
        $marks=$this->markRepository->getAllMarks();
        return view('dashboard.site.merchants.products.create',compact(['categories','marks','id']));
    }

    public function createWithCode($id){
        return view('dashboard.site.merchants.products.create-with-code',compact(['id']));
    }

    public function merchantsProducts($id){
        $products=$this->productRepository->paginateWithQuery(['user_id' => $id],25,['mainImage']);
        return view('dashboard.site.merchants.products.index', compact(['products','id']));
    }
}
