<?php

namespace App\Repository\Eloquent;

use App\Models\Post;
use App\Repository\PostRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class PostRepository extends Repository implements PostRepositoryInterface
{
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }
    public function cursorPosts($per_page,$relations=[]){
        $query=$this->model::query();
        $request=request();
        if ($request->key) {
            $cleaned = preg_replace('/[^\p{L}\p{N}\s]/u', '', $request->key); // keep only letters, numbers, and space

            $searchTerms = collect(explode(' ', $cleaned))
                ->map(fn($term) => trim($term))
                ->filter(fn($term) => strlen($term) > 1) // skip empty or 1-char words
                ->map(fn($term) => '+' . $term . '*')
                ->implode(' ');

            $query->whereRaw("MATCH(description) AGAINST(? IN BOOLEAN MODE)", [$searchTerms]);
        }
        if($request->category_id)
            $query->where('category_id',(int) $request->category_id);
        if($request->mark_id)
            $query->where('mark_id',(int) $request->mark_id);
        if($request->model_id)
            $query->where('model_id',(int) $request->model_id);
        if($request->city_id)
            $query->where('city_id',(int) $request->city_id);
        if($request->year_from && $request->year_to){
            $query->whereBetween('year',[ $request->year_from , $request->year_to]);
        }
        $query->withCount('comments');
        return $query->with($relations)->latest('updated_at')->cursorPaginate($per_page,cursorName: 'page')->appends(request()->query());
    }

}
