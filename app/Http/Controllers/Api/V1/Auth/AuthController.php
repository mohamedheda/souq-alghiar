<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\SignInRequest;
use App\Http\Requests\Api\V1\Auth\SignUpRequest;
use App\Http\Requests\Api\V1\Auth\SocialSignRequest;
use App\Http\Requests\Api\V1\Auth\User\UpdateProfileRequest;
use App\Http\Services\Api\V1\Auth\AuthService;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $auth,
    )
    {
    }

    public function signUp(SignUpRequest $request) {
        return $this->auth->signUp($request);
    }
    public function socialSign(SocialSignRequest $request) {
        return $this->auth->socialSign($request);
    }

    public function signIn(SignInRequest $request) {
        return $this->auth->signIn($request);
    }

    public function signOut()
    {
        return $this->auth->signOut();
    }

    public function whatIsMyPlatform()
    {
        return $this->auth->whatIsMyPlatform();
    }
    public function getProfileData(){
        return $this->auth->getProfileData();
    }
    public function updateProfileData(UpdateProfileRequest $request) {
        return $this->auth->updateProfileData($request);
    }
}
