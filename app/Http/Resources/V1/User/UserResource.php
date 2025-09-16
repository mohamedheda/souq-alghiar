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
            'id' => $this->id,
            'name' => $this->name,
            'user_type' => $this->user_type,
            'email' => $this->email,
            'user_name' => $this->whenNotNull($this->user_name),
            'address' => $this->whenNotNull($this->address),
            'image' => $this->whenNotNull($this->imageUrl),
            'cover' => $this->whenNotNull($this->coverUrl),
            'otp_token' => $this->whenNotNull($this->otp?->token),
            'otp_verified' => $this->whenNotNull($this->otp_verified),
            'can_add_product' => $this->whenNotNull($this->canAddProduct),
            'can_add_featured_product' => $this->whenNotNull($this->canAddFeaturedProduct),
            'can_add_comment' => $this->whenNotNull($this->canAddComment),
            'can_add_pinned_comment' => $this->whenNotNull($this->canAddPinnedComment),
            'token' => $this->when($this->withToken, $this->token()),
        ];
    }
}
