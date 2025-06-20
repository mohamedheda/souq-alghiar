<?php

namespace App\Http\Resources\V1\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileDataResource extends JsonResource
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
            'email' => $this->email,
            'user_name' => $this->user_name,
            'phone' => $this->whenNotNull($this->phone),
            'image' => $this->whenNotNull($this->imageUrl),
            'cover' => $this->whenNotNull($this->coverUrl),
            'address' => $this->whenNotNull($this->address),
            'city_id' => $this->whenNotNull($this->city_id),
        ];
    }
}
