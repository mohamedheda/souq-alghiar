<?php

namespace App\Http\Services\Api\V1\User;

use App\Http\Resources\V1\User\UserProfileResource;
use App\Http\Traits\Responser;
use App\Repository\UserRepositoryInterface;

class UserService
{
    use Responser;
    public function __construct(
        private readonly UserRepositoryInterface $userRepository ,
    )
    {

    }
    public function getUserProfile($user_name)
    {

        $user=$this->userRepository->getByUserName($user_name);
        if(! $user){
            return $this->responseFail(message: __('messages.This user does not exist.'));
        }
        // TODO return wrong if user is unactive due to subscription
        return $this->responseSuccess(data: UserProfileResource::make($user));
    }
}
