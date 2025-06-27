<?php

namespace App\Http\Controllers\Api\V1\Home;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\Home\HomeContentService;
use Illuminate\Http\Request;

class HomeContentController extends Controller
{
    public function __construct(
        private HomeContentService $homeContentService
    )
    {

    }
    public function categoriesAndMarks(){
        return $this->homeContentService->categoriesAndMarks();
    }
    public function postsAndProducts(){
        return $this->homeContentService->postsAndProducts();
    }
}
