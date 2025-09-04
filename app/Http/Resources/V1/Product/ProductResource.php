<?php

namespace App\Http\Resources\V1\Product;

use App\Http\Resources\V1\Product\ProductHelper\ProductImageResource;
use App\Http\Resources\V1\Product\ProductHelper\ProductMakeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'image' => ProductImageResource::make($this->whenLoaded('mainImage')),
            'featured' => $this->featured,
            'title' => $this->title,
            'price' => $this->priceValue,
            'currency' => $this->productCurrency,
            'all_makes' => $this->all_makes ,
            'makes' => $this->when(!$this->all_makes, ProductMakeResource::collection($this->markes->take(3))),
            'more_than_main_makes' => $this->moreThanMainMarkes ,
            'user_image' => $this->user?->imageUrl,
            'user_name' => $this->user?->name,
            'views' => $this->views,
            'ago_time' => $this->updateAtDiff,
        ];
    }
}
