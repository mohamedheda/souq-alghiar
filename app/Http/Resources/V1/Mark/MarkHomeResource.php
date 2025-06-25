<?php

namespace App\Http\Resources\V1\Mark;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MarkHomeResource extends JsonResource
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
            'logo' => $this->imageUrl ,
        ];
    }
}
