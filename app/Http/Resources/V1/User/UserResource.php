<?php

namespace App\Http\Resources\V1\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function __construct($resource, private readonly bool $withToken)
    {
        parent::__construct($resource);
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'image' => $this->whenNotNull($this->image),
            'otp_token' => $this->whenNotNull($this->otp?->token),
            'otp_verified' => $this->whenNotNull($this->otp_verified),
            'can_add_product' => $this->whenNotNull($this->canAddProduct),
            'token' => $this->when($this->withToken, $this->token()),
        ];
    }
}
