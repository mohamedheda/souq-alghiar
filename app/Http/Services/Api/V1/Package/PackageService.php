<?php

namespace App\Http\Services\Api\V1\Package;

use App\Http\Resources\V1\Package\PackageResource;
use App\Http\Traits\Responser;
use App\Repository\PackageRepositoryInterface;

class PackageService
{
    use Responser;
    public function __construct(
        private readonly PackageRepositoryInterface $packageRepository
    )
    {

    }
    public function index(){
        $packages=$this->packageRepository->getAll(relations: ['features']);
        return $this->responseSuccess(data: PackageResource::collection($packages));
    }

}
