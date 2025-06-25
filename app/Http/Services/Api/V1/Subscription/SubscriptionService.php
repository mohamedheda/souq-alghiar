<?php

namespace App\Http\Services\Api\V1\Subscription;

use App\Http\Resources\V1\Subscription\SubscriptionResource;
use App\Http\Traits\Responser;
use App\Repository\PackageRepositoryInterface;
use App\Repository\SubscriptionRepositoryInterface;
use Carbon\Carbon;

class SubscriptionService
{
    use Responser;
    const ACTIVE=1;
    public function __construct(
        private readonly PackageRepositoryInterface $packageRepository ,
        private readonly SubscriptionRepositoryInterface $subscriptionRepository ,
    )
    {

    }

    public function index(){
        try {
            $user=auth('api')->user();
            $user->load('lastSubscription.package','subscriptions.package');
            $data=[
                'subscription_active' => $user->subscription_active ,
                'subscription_active_title' => $user->subscriptionActiveTitle ,
                'package_name' => $user->lastSubscription?->package?->t('name') ,
                'starts_on' => $user->lastSubscription?->starts_on ,
                'ends_on' => $user->lastSubscription?->ends_on ,
                'products' => $user->productsAvailableCount ,
                'featured_products' => $user->featuredProductsAvailableCount ,
                'comments' => $user->commentsAvailableCount ,
                'pinned_comments' => $user->pinnedCommentsAvailableCount ,
                'is_yearly' => $user->lastSubscription?->is_yearly ,
                'subscriptions' => SubscriptionResource::collection($user->subscriptions) ,
            ];
            return $this->responseSuccess(data: $data);
        }catch (\Exception $exception){
            return $exception->getMessage();
            return $this->responseFail(message: __('messages.Something Went Wrong'));
        }
    }

    public function confirm($request){
        try {
            // TODO : Verify Payment with the gateway
            $package=$this->packageRepository->getById($request->package_id );
            $user = auth('api')->user();
            $data=[
                'user_id' => $user->id ,
                'package_id' => $package->id ,
                'price' => $package->price ,
                'months' => $package->months ,
            ];
            $user_data=$this->getNewSubscriptionData($user,$package);
            $data=array_merge($data,$user_data);
            $this->subscriptionRepository->create($data);
            $user_data['subscription_ends_at'] = Carbon::parse($user->subscription_ends_at)->addMonths($package->months);
            $user_data['subscription_active'] = self::ACTIVE;
            auth('api')->user()->update($user_data);
            return $this->responseSuccess(message: __('messages.Subscription Added Successfully'));
        }catch (\Exception $exception){
//            return $exception->getMessage();
            return $this->responseFail(message: __('messages.Something Went Wrong'));
        }
    }
    public function confirmDefaultPackage($user){
        try {
            $package=$this->packageRepository->first('default_package',1);
            if(!$package)
                return $this->responseFail(message: __('messages.Something Went Wrong'));
            $data=[
                'user_id' => $user->id ,
                'package_id' => $package->id ,
                'price' => 0 ,
                'months' => $package->months ,
            ];
            $user_data=$this->getNewSubscriptionData($user,$package);
            $data=array_merge($data,$user_data);
            $this->subscriptionRepository->create($data);
            $user_data['subscription_ends_at'] = Carbon::parse($user->subscription_ends_at)->addMonths($package->months);
            $user_data['subscription_active'] = self::ACTIVE;
            $user->update($user_data);
            return $this->responseSuccess(message: __('messages.Subscription Added Successfully'));
        }catch (\Exception $exception){
//            return $exception->getMessage();
            return $this->responseFail(message: __('messages.Something Went Wrong'));
        }
    }
    private function getNewSubscriptionData($user,$package){
        $user_data['products'] = is_null($user->products) || is_null($package->products)
            ? null
            : $user->products + $package->products;

        $user_data['featured_products'] = is_null($user->featured_products) || is_null($package->featured_products)
            ? null
            : $user->featured_products + $package->featured_products;

        $user_data['comments'] = is_null($user->comments) || is_null($package->comments)
            ? null
            : $user->comments + $package->comments;

        $user_data['pinned_comments'] = is_null($user->pinned_comments) || is_null($package->pinned_comments)
            ? null
            : $user->pinned_comments + $package->pinned_comments;
        return $user_data;
    }
}
