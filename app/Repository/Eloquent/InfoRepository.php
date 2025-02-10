<?php

namespace App\Repository\Eloquent;

use App\Models\Info;
use App\Repository\InfoRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class InfoRepository extends Repository implements InfoRepositoryInterface
{
    public function __construct(Info $model)
    {
        parent::__construct($model);
    }

    public function getValue(string $key, $default = null)
    {
        return $this->model::where('key', $key)->value('value') ?? $default;
    }
}
