<?php

namespace App\Http\Resources\V1\Post;

use App\Http\Resources\V1\Post\Helper\PostImageResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostDetailsResource extends JsonResource
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
            'user_name' => $this->user?->name ,
            'user_image' => $this->user?->imageUrl ,
            'created_at' => Carbon::parse($this->updated_at)->diffForHumans() ,
            'mark' => $this->mark?->imageUrl ,
            'description' => $this->description ,
            'images' => PostImageResource::collection($this->whenLoaded('images')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')) ,
        ];
    }
}
