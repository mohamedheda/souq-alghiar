<?php

namespace App\Http\Resources\V1\Product\ProductHelper;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductMakeDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'make_id' => $this->id ,
            'make' => $this->make?->imageUrl,
            'model_id' => $this->model?->id ,
            'model' => $this->model?->t('name'),
            'year_from' => $this->year_from,
            'year_to' => $this->year_to,
        ];
    }
}
