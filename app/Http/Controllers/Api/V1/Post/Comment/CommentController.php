<?php

namespace App\Http\Controllers\Api\V1\Post\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Post\Comment\CommentRequest;
use App\Http\Services\Api\V1\Post\Comment\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct(private CommentService $commentService)
    {

    }
    public function store(CommentRequest $request)
    {
        return $this->commentService->store($request);
    }
    public function delete($id)
    {
        return $this->commentService->delete($id);
    }

}
