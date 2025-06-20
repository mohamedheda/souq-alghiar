<?php

namespace App\Http\Controllers\Api\V1\City;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\City\CityResource;
use App\Http\Traits\Responser;
use App\Repository\CityRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CityController extends Controller
{
    use Responser;

    public function __construct(
        private readonly CityRepositoryInterface $cityRepository
    )
    {

    }

    public function index()
    {
        $cities = Cache::rememberForever('cities',fn() => $this->cityRepository->getCities());
        return $this->responseSuccess(data: CityResource::collection($cities));
    }
}
