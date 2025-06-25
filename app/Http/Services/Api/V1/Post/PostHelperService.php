<?php

namespace App\Http\Services\Api\V1\Post;

use App\Http\Services\Mutual\FileManagerService;
use App\Repository\PostImageRepositoryInterface;
use App\Repository\UserRepositoryInterface;

class PostHelperService
{

    public function __construct(
        private readonly FileManagerService      $fileManagerService,
        private readonly UserRepositoryInterface $userRepository,
    )
    {

    }

    public function attachImages($images, $post)
    {
        $saved_image_paths = [];
        foreach ($images as $image) {
            $saved_image_paths[] = ['image' => $this->fileManagerService->uploadFile($image, 'products')];
        }
        $post->images()?->createMany($saved_image_paths);
    }

    public function decreaseCommentsCount($pinned)
    {
        if ($pinned){
            if (!is_null(auth('api')->user()?->pinned_comments))
                $this->userRepository->decrementValue('pinned_comments', 1
                    , auth('api')->id());
        }else{
            if (!is_null(auth('api')->user()?->comments))
                $this->userRepository->decrementValue('comments', 1
                    , auth('api')->id());
        }
    }
}
