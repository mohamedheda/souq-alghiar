<?php

namespace App\Http\Controllers\Api\V1\Subscription;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Subscription\SubscriptionRequest;
use App\Http\Services\Api\V1\Subscription\SubscriptionService;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function __construct(
        private readonly SubscriptionService $subscriptionService ,
    )
    {

    }
    public function index(){
        return $this->subscriptionService->index();
    }
    public function confirm(SubscriptionRequest $request){
        return $this->subscriptionService->confirm($request);
    }
}
