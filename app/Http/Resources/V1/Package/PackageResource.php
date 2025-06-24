<?php

namespace App\Http\Resources\V1\Package;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
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
            'name' => $this->t('name') ,
            'price' => $this->priceValue ,
            'duration' => $this->durationValue ,
            'promotional_text' => $this->whenNotNull($this->promotional_text) ,
            'features' => PackageFeatureResource::collection($this->whenLoaded('features')) ,
        ];
    }
}
