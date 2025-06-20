<?php

namespace App\Http\Controllers\Api\V1\Mark;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Mark\MarkResource;
use App\Http\Traits\Responser;
use App\Repository\MarkRepositoryInterface;
use App\Repository\ModelRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MarkController extends Controller
{
    use Responser;
    public function __construct(
        private readonly MarkRepositoryInterface $markRepository,
        private readonly ModelRepositoryInterface $modelRepository,

    )
    {

    }
    public function index()
    {
        $marks = Cache::rememberForever('marks',fn()=> $this->markRepository->getAllMarks());
        return $this->responseSuccess(data: MarkResource::collection($marks));
    }

    public function getModels($mark_id)
    {
        $models = $this->modelRepository->getModelsByMark($mark_id);
        return $this->responseSuccess(data: MarkResource::collection($models));
    }
}
