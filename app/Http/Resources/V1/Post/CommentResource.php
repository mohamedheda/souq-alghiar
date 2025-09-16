<?php

namespace App\Http\Resources\V1\Post;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'created_at' => Carbon::parse($this->updated_at)->diffForHumans() ,
            'user_image' => $this->user?->imageUrl ,
            'user_id' => $this->user_id ,
            'comment' => $this->comment ,
            'pinned' => $this->pinned,
            'replies' => CommentResource::collection($this->whenLoaded('replies')) ,
        ];
    }
}
