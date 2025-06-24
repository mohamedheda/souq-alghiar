<?php

namespace App\Repository\Eloquent;

use App\Models\Subscription;
use App\Repository\SubscriptionRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class SubscriptionRepository extends Repository implements SubscriptionRepositoryInterface
{
    public function __construct(Subscription $model)
    {
        parent::__construct($model);
    }
}
