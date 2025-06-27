<?php

namespace App\Http\Resources\V1\Post;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class PostResource extends JsonResource
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
            'description' => Str::limit($this->description,200) ,
            'category' => $this->category?->t('name') ,
            'city' => $this->city?->t('name') ,
            'comments_count' => is_null($this->comments_count) ? 0 ." " .__('messages.comments') : $this->comments_count ." " .__('messages.comments') ,
        ];
    }
}
