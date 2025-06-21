<?php

namespace App\Repository\Eloquent;

use App\Models\Product;
use App\Repository\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ProductRepository extends Repository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }
    public function cursorProducts($per_page,$relations=[],$user_id=null){
        $query= $this->model::query();
        $request=request();
        if($user_id)
            $query->where('user_id',(int) $request->user_id);
        if ($request->key) {
            $cleaned = preg_replace('/[^\p{L}\p{N}\s]/u', '', $request->key); // keep only letters, numbers, and space

            $searchTerms = collect(explode(' ', $cleaned))
                ->map(fn($term) => trim($term))
                ->filter(fn($term) => strlen($term) > 1) // skip empty or 1-char words
                ->map(fn($term) => '+' . $term . '*')
                ->implode(' ');
            $query->whereRaw("MATCH(title, description) AGAINST(? IN BOOLEAN MODE)", [$searchTerms]);
        }
        if($request->category_id)
            $query->where('category_id',(int) $request->category_id);
        if($request->category_id)
            $query->where('sub_category_id',(int) $request->sub_category_id);
        if ($request->city_id)
            $query->whereHas('user',function ($q) use ($request){
                if($request->city_id)
                    $q->where('city_id',$request->city_id);
            });
        if ($request->mark_id || $request->model_id || $request->year ){
            $query->whereHas('markes',function ($q) use ($request){
                if($request->mark_id)
                    $q->where('mark_id',$request->mark_id);
                if($request->model_id)
                    $q->where('model_id',$request->model_id);
                if($request->year)
                    $q->where('year_from','<=',$request->year)->where('year_to','<=',$request->year);
            });
        }
        $query->withCount('markes');
        return $query->with($relations)->orderByDesc('featured')->latest('updated_at')->cursorPaginate($per_page,cursorName: 'page')->appends(request()->query());
    }

    public function getSimilarProducts($product,$relations=[]){
        if ($this->model::query()->count() === 0) {
            return null;
        }

        $similar = collect();

        $userProductsCount = $this->model::query()->where('user_id', $product->user_id)->count();
        if ($userProductsCount > 1) {
            $similar = $this->model::query()->where('user_id', $product->user_id)
                ->where('id', '!=', $product->id)
                ->latest('updated_at')
                ->limit(4)
                ->with($relations)
                ->get();
        }

        if ($similar->count() < 4) {
            $needed = 4 - $similar->count();

            $subCategoryMatches = $this->model::query()->where('sub_category_id', $product->sub_category_id)
                ->where('id', '!=', $product->id)
                ->whereNotIn('id', $similar->pluck('id'))
                ->latest('updated_at')
                ->limit($needed)
                ->with($relations)
                ->get();

            $similar = $similar->concat($subCategoryMatches);
        }

        if ($similar->count() < 4) {
            $needed = 4 - $similar->count();

            $categoryMatches = $this->model::query()->where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->whereNotIn('id', $similar->pluck('id'))
                ->latest('updated_at')
                ->limit($needed)
                ->with($relations)
                ->get();

            $similar = $similar->concat($categoryMatches);
        }

        if ($similar->count() < 4) {
            $needed = 4 - $similar->count();

            $fallback = $this->model::query()->where('id', '!=', $product->id)
                ->whereNotIn('id', $similar->pluck('id'))
                ->latest('updated_at')
                ->limit($needed)
                ->with($relations)
                ->get();

            $similar = $similar->concat($fallback);
        }

        return $similar;
    }
}
