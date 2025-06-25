<?php

namespace App\Http\Services\Api\V1\Post\Comment;

use App\Http\Services\Api\V1\Post\PostHelperService;
use App\Http\Traits\Responser;
use App\Repository\CommentRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class CommentService
{
    use Responser;
    const COMMENT="comment";
    const REPLY="reply";
    public function __construct(
        private readonly CommentRepositoryInterface $commentRepository ,
        private PostHelperService $helperService ,
    )
    {

    }
    public function store($request)
    {
        DB::beginTransaction();
        try {
            $response = Gate::inspect('add-comment', [$request->pinned]);
            if ($response->allowed()) {
                $data = $request->except('type');
                $data['user_id'] = auth('api')->id();
                if($request->type == self::COMMENT ){
                    $data['post_id'] = $request->parent_id;
                    $data['parent_id'] = null;
                }
                $this->commentRepository->create($data);
                $this->helperService->decreaseCommentsCount($request->pinned);
            } else {
                return $this->responseFail(message: $response->message());
            }
            DB::commit();
            return $this->responseSuccess(message: __('messages.created successfully'));
        } catch (Exception $e) {
            DB::rollBack();
//            return $e;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $this->commentRepository->delete($id);
            DB::commit();
            return $this->responseSuccess(message: __('messages.deleted successfully'));
        } catch (Exception $e) {
            DB::rollBack();
//            return $e;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
}
