<?php

namespace App\Http\Resources\V1\Product;

use App\Http\Resources\V1\Pagination\PaginationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductPaginationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => ProductResource::collection($this) ,
            'meta' => PaginationResource::make($this) ,
        ];
    }
}
