<?php

namespace App\Http\Services\Api\V1\Post;

use App\Http\Services\Mutual\FileManagerService;
use App\Repository\PostImageRepositoryInterface;

class PostHelperService
{

    public function __construct(
        private readonly FileManagerService              $fileManagerService,
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
}
