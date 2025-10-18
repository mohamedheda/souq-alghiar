<?php

namespace App\Http\Resources\V1\Product;

use App\Http\Resources\V1\Product\ProductHelper\ProductImageResource;
use App\Http\Resources\V1\Product\ProductHelper\ProductMakeDetailsResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id ,
            'category_id' => $this->category_id ,
            'sub_category_id' => $this->sub_category_id ,
            'labels' => $this->labels,
            'title' => $this->title,
            'price' => $this->priceValue,
            'currency' => $this->productCurrency,
            'description' => $this->description,
            'images' => ProductImageResource::collection($this->images),
            'featured' => $this->featured,
            'all_makes' => $this->all_makes,
            'makes' => $this->when(!$this->all_makes, ProductMakeDetailsResource::collection($this->whenLoaded('markes'))),
            'similar_products' => ProductResource::collection($this->similar_products)
        ];

    }
}
