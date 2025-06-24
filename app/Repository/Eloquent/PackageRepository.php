<?php

namespace App\Repository\Eloquent;

use App\Models\Package;
use App\Repository\PackageRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class PackageRepository extends Repository implements PackageRepositoryInterface
{
    public function __construct(Package $model)
    {
        parent::__construct($model);
    }

}
