<?php

namespace App\Http\Resources\V1\Subscription;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'package_name' => $this->package?->t('name') ,
            'starts_on' => $this->starts_on ,
            'ends_on' => $this->ends_on ,
            'duration' => $this->duration ,
            'price' => $this->price . " ".__('messages.LE') ,
        ];
    }
}
