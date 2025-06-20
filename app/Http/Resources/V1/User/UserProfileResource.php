<?php

namespace App\Http\Resources\V1\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
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
            'name' => $this->name,
            'image' => $this->whenNotNull($this->imageUrl),
            'cover' => $this->whenNotNull($this->coverUrl),
            'phone' => $this->whenNotNull($this->phone),
            'address' => $this->whenNotNull($this->address),
        ];
    }
}
