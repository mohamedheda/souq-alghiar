<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends Repository implements UserRepositoryInterface
{
    protected Model $model;

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getActiveUsers()
    {
        return $this->model::query()->where('is_active', true);
    }

    public function incrementValue(string $key, int $amount = 1, $id = null)
    {
        return $this->model::where('id', $id)->increment($key, $amount);
    }

    public function decrementValue(string $key, int $amount = 1, $id = null)
    {
        return $this->model::where('id', $id)->decrement($key, $amount);
    }
}
