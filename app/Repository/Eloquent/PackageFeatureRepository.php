<?php

namespace App\Repository\Eloquent;

use App\Models\PackageFeature;
use App\Repository\PackageFeatureRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class PackageFeatureRepository extends Repository implements PackageFeatureRepositoryInterface
{
    public function __construct(PackageFeature $model)
    {
        parent::__construct($model);
    }
}
