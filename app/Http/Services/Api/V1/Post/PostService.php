<?php

namespace App\Http\Services\Api\V1\Post;

use App\Http\Resources\V1\Post\PostDetailsResource;
use App\Http\Resources\V1\Post\PostPaginationResource;
use App\Http\Services\Mutual\FileManagerService;
use App\Http\Traits\Responser;
use App\Repository\PostImageRepositoryInterface;
use App\Repository\PostRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PostService
{
    use Responser;


    public function __construct(
        private readonly FileManagerService      $fileManagerService,
        private readonly PostRepositoryInterface $postRepository,
        private readonly PostHelperService       $helperService,

    )
    {

    }

    public function index()
    {
        $posts = $this->postRepository->cursorPosts(15, ['user:id,name,image', 'mark:id,logo', 'category:id,name_ar,name_en', 'city:id,name_ar,name_en']);
        return $this->responseSuccess(data: PostPaginationResource::make($posts));
    }

    public function show($id)
    {
        try {
            $post = $this->postRepository->getById($id,columns: ['id','user_id','description','mark_id','updated_at'],
                relations: ['images:id,post_id,image'
                , 'user:id,name,image', 'mark:id,logo','comments:id,user_id,pinned,post_id,comment,updated_at'
                ,'comments.replies:id,user_id,pinned,parent_id,comment,updated_at','comments.user:id,name,image'
                ,'comments.replies.user:id,name,image']);
            return $this->responseSuccess(data: PostDetailsResource::make($post));
        } catch (Exception $e) {
//            return $e;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {

            $data = $request->except(['images']);
            $data['user_id'] = auth('api')->id();
            $post = $this->postRepository->create($data);
            if ($request->images && is_array($request->images))
                $this->helperService->attachImages($request->images, $post);
            DB::commit();
            return $this->responseSuccess(message: __('messages.created successfully'));
        } catch (Exception $e) {
            DB::rollBack();
//            return $e;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

}
