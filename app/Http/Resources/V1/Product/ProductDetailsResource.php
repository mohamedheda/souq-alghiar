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
            'labels' => $this->labels,
            'title' => $this->title,
            'price' => $this->priceValue,
            'currency' => $this->productCurrency,
            'description' => $this->description,
            'images' => ProductImageResource::collection($this->images),
            'featured' => $this->featured,
            'makes' => $this->when(!$this->all_makes, ProductMakeDetailsResource::collection($this->whenLoaded('markes'))),
            'similar_products' => ProductResource::collection($this->similar_products)
        ];

    }
}
