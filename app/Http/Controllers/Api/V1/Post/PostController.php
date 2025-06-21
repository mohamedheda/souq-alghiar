<?php

namespace App\Http\Controllers\Api\V1\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Post\PostRequest;
use App\Http\Services\Api\V1\Post\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(private PostService $postService)
    {

    }
    public function index(){
        return $this->postService->index();
    }
    public function store(PostRequest $request)
    {
        return $this->postService->store($request);
    }

    public function update($id, PostRequest $request)
    {
        return $this->postService->update($id, $request);
    }
    public function delete($id)
    {
        return $this->postService->delete($id);
    }
    public function show($id)
    {
        return $this->postService->show($id);
    }
}
