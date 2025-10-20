<?php

namespace App\Http\Services\Api\V1\Product;

use App\Http\Services\Api\V1\Sphinx\SphinxService;
use App\Http\Services\Mutual\FileManagerService;
use App\Repository\Eloquent\UserRepository;
use App\Repository\InfoRepositoryInterface;
use App\Repository\MarkRepositoryInterface;
use App\Repository\ModelRepositoryInterface;
use App\Repository\ProductImageRepositoryInterface;
use App\Repository\ProductMakesRepositoryInterface;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProductHelperService
{
    public function __construct(
        private readonly FileManagerService              $fileManagerService,
        private readonly UserRepository                  $userRepository,
        private readonly ProductMakesRepositoryInterface $productMakesRepository,
        private readonly ProductImageRepositoryInterface $productImageRepository,
        private readonly MarkRepositoryInterface $markRepository,
        private readonly ModelRepositoryInterface $modelRepository,
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

    public function decreaseProductsCount($featured,$user=null)
    {
        if(! $user)
            $user=auth('api')->user();
        if ($featured){
            if (!is_null($user?->featured_products))
                $this->userRepository->decrementValue('featured_products', 1
                , $user->id);
        } else{
            if (!is_null($user?->products))
                $this->userRepository->decrementValue('products', 1
                , $user->id);
        }

    }

    public function prepareLabels($product)
    {
        $labels = [];
        $labels[] = $product->used ? __('messages.Used') : __('messages.New') ;
        if ($product->category_id)
            $labels[] = $product->category->t('name');
        if ($product->all_makes)
            $labels[] = __('messages.all_makes');
        return $labels;
    }


    public function filterProductsUsingSphinx($request)
    {
        $query = "";
        if ($request->key) {
            $key = addslashes($request->key);
            $query .= "@(title,description) $key";
        }
        $filters = [];
        if ($request->category_id) {
            $filters['category_id'] = (int)$request->category_id;
        }
        if ($request->sub_category_id) {
            $filters['sub_category_id'] = (int)$request->sub_category_id;
        }
        if ($request->city_id) {
            $filters['city_id'] = (int)$request->city_id;
        }
        if ($request->mark_id) {
            $filters['mark_id'] = (int)$request->mark_id;
        }
        if ($request->model_id) {
            $filters['model_id'] = (int)$request->model_id;
        }
        $range_query = null;
        if ($request->year) {
            $year = (int)$request->year;
            $range_query = " AND year_from <= $year AND year_to >= $year;";
        }


        $data = $this->sphinxService->search('products_index', $query, $filters, $range_query);
        return $data;
    }
    public function attachImagesT($product,$gallery){
        if (!empty($gallery)){
            foreach ($gallery as $key => $img) {
                // Skip the first one with frames (360° image)
                if ($key === 0 && !empty($img->frames)) {
                    continue;
                }

                $src = $img->src ?? null;
                if (!$src) continue;
                // Build full image URL
                $imgUrl = "https://picdn.trodo.com/media/m2_catalog_cache/480x480" . urldecode($src) . "?1";

                try {
                    $response = Http::get($imgUrl);

                    if ($response->ok()) {

                        $folder = "products";

                        // Generate unique image name
                        $filename = $folder . '/' . uniqid('prod',more_entropy: true) . '.jpg';

                        // Save to storage/app/public
                        Storage::disk('public')->put($filename, $response->body());

                        // Save record in product_images table
                        \DB::table('product_images')->insert([
                            'product_id' => $product->id,
                            'image'      => "storage/".$filename,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                    }
                } catch (\Exception $e) {
                    // Log errors, skip this image
                    \Log::error("Failed to download image: {$imgUrl} | Error: {$e->getMessage()}");
                }
            }
        }
    }
    public function attachMakesT($product_id,$apiData){
        $makes=$this->markRepository->getAll(relations: ['models']);

            $markMap = [];
            foreach ($makes as $mark) {
                $markKey = $this->normalizeName($mark->name_en);
                $modelsMap = [];
                foreach ($mark->models as $model) {
                    $modelKey = $this->normalizeName($model->name_en);
                    $modelsMap[$modelKey] = $model;
                }
                $markMap[$markKey] = [
                    'mark' => $mark,
                    'modelsMap' => $modelsMap
                ];
            }

            $insertData = [];
            if ($apiData->list){
                // Step 2: Loop over API vehicles
                foreach ($apiData->list as $auto) {
                    $autoName = $this->normalizeName($auto->automaker_label->name);

                    // Match mark or classify using Gemini
                    if (isset($markMap[$autoName])) {
                        $markEntry = $markMap[$autoName];
                        $mark = $markEntry['mark'];
                        $modelsMap = $markEntry['modelsMap'];
                    } else {
                        // Gemini classifies mark
                        $geminiPrompt = "Classify this automaker name '{$auto->automaker_label->name}' and return a JSON: {\"name_en\":\"\",\"name_ar\":\"\"}";
                        $geminiResult = Gemini::generativeModel('gemini-2.0-flash')->generateContent($geminiPrompt);
                        $markData = json_decode($geminiResult->text(), true);

                        $mark = $this->markRepository->create([
                            'name_en' => $markData['name_en'] ?? $auto->automaker_label->name,
                            'name_ar' => $markData['name_ar'] ?? $auto->automaker_label->name
                        ]);

                        $modelsMap = [];
                        $markMap[$autoName] = ['mark' => $mark, 'modelsMap' => $modelsMap];
                    }

                    // Step 3: Loop over models
                    foreach ($auto->model_list as $modelItem) {
                        $modelName = $this->normalizeName($modelItem->label->name);

                        if (isset($modelsMap[$modelName])) {
                            $model = $modelsMap[$modelName];
                        } else {
                            // Gemini classifies model
                            $geminiPrompt = "Classify this model name '{$modelItem->label->name}' for automaker '{$mark->name_en}' and return JSON: {\"name_en\":\"\",\"name_ar\":\"\"}";
                            $geminiResult = Gemini::generativeModel('gemini-2.0-flash')->generateContent($geminiPrompt);
                            $modelData = json_decode($geminiResult->text(), true);

                            $model = $this->modelRepository->create([
                                'mark_id' => $mark->id,
                                'name_en' => $modelData['name_en'] ?? $modelItem->label->name,
                                'name_ar' => $modelData['name_ar'] ?? $modelItem->label->name
                            ]);

                            $modelsMap[$modelName] = $model;
                            $markMap[$autoName]['modelsMap'] = $modelsMap;
                        }

                        // Step 4: Collect for product_marks
                        $insertData[] = [
                            'product_id' => $product_id,
                            'mark_id' => $mark->id,
                            'model_id' => $model->id,
                            'year_from' => (int) $modelItem->label->year_from,
                            'year_to' => (int) $modelItem->label->year_to ?: 0,
                        ];
                    }
                }
                $this->productMakesRepository->insert($insertData);
            }

        }

        private function mapDBNames(){
        $makes=$this->markRepository->getAll(relations: ['models']);
        $markMap = [];
        foreach ($makes as $mark) {
            $markKey = $this->normalizeName($mark->name_en);
            $markMap[$markKey] = $mark;

            foreach ($mark->models as $model) {
                $modelKey = $this->normalizeName($model->name_en);
                $modelsMap[$modelKey] = $model;
            }

            // store both mark and modelsMap in markMap
            $markMap[$markKey] = [
                'mark' => $mark,
                'modelsMap' => $modelsMap
            ];
        }
        return $markMap;
    }

    private function normalizeName(string $name): string {
        // lowercase, remove extra spaces, remove special chars
        $name = mb_strtolower($name, 'UTF-8');
        $name = preg_replace('/[^\p{L}\p{N}]+/u', '', $name);
        return trim($name);
    }
}
