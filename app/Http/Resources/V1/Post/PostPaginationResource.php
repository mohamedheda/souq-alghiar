<?php

namespace App\Http\Resources\V1\Post;

use App\Http\Resources\V1\Pagination\PaginationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostPaginationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => PostResource::collection($this) ,
            'meta' => PaginationResource::make($this) ,
        ];
    }
}
