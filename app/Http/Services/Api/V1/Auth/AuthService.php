<?php

namespace App\Http\Services\Api\V1\Auth;

use App\Http\Requests\Api\V1\Auth\SignInRequest;
use App\Http\Requests\Api\V1\Auth\SignUpRequest;
use App\Http\Resources\V1\User\UserResource;
use App\Http\Services\Api\V1\Auth\Otp\OtpService;
use App\Http\Services\Mutual\FileManagerService;
use App\Http\Services\PlatformService;
use App\Http\Traits\Responser;
use App\Repository\InfoRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

abstract class AuthService extends PlatformService
{
    use Responser;

    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly OtpService              $otpService,
        private readonly FileManagerService      $fileManagerService,
    )
    {
    }

    public function signUp(SignUpRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['wallet'] = app(InfoRepositoryInterface::class)->getValue("default_" . $request->type . "_wallet_points", 0);
            if ($request->image != null)
                $data['image'] = $this->fileManagerService->upload('image', 'users');
            $user = $this->userRepository->create($data);
            $this->otpService->generate($user);
            $user->load('otp');
            DB::commit();
            return $this->responseSuccess(message: __('messages.created successfully'), data: new UserResource($user, true));
        } catch (Exception $e) {
            DB::rollBack();
//            dd($e);
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function signIn(SignInRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $token = auth('api')->attempt($credentials);
        if ($token) {
            return $this->responseSuccess(message: __('messages.Successfully authenticated'), data: new UserResource(auth('api')->user(), true));
        }

        return $this->responseFail(status: 401, message: __('messages.wrong credentials'));
    }

    public function signOut()
    {
        auth('api')->logout();
        return $this->responseSuccess(message: __('messages.Successfully loggedOut'));
    }

}
