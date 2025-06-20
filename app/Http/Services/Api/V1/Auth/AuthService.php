<?php

namespace App\Http\Services\Api\V1\Auth;

use App\Http\Enums\UserType;
use App\Http\Requests\Api\V1\Auth\SignInRequest;
use App\Http\Requests\Api\V1\Auth\SignUpRequest;
use App\Http\Requests\Api\V1\Auth\SocialSignRequest;
use App\Http\Resources\V1\User\UserProfileDataResource;
use App\Http\Resources\V1\User\UserResource;
use App\Http\Services\Api\V1\Auth\Otp\OtpService;
use App\Http\Services\Mutual\FileManagerService;
use App\Http\Services\PlatformService;
use App\Http\Traits\Responser;
use App\Models\User;
use App\Repository\InfoRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class AuthService extends PlatformService
{
    const VERIFIED = 1;
    use Responser;

    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly OtpService              $otpService,
        private readonly FileManagerService      $fileManagerService,
    )
    {
    }

    public function socialSign(SocialSignRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            $socialUser = Socialite::driver($data['provider'])->stateless()->userFromToken($data['token']);
            if (!$socialUser)
                return $this->responseFail(message: 'User not found. Please register first.');

            $user = $this->userRepository->updateOrCreate([
                'email' => $socialUser->getEmail(),
                'provider' => $data['provider'],
                'provider_id' => $socialUser->getId()
            ], [
                'name' => $socialUser->getName() ?? 'user',
                'image' => $socialUser->getAvatar(),
                'otp_verified' => self::VERIFIED,
                'type' => UserType::User->value,
                'password' => Hash::make(str()->random(16)),
            ]);
            $user->token = JWTAuth::fromUser($user);
            DB::commit();
            return $this->responseSuccess(message: __('messages.created successfully'), data: new UserResource($user, true));
        } catch (Exception $e) {
            DB::rollBack();
//            return $e;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function signUp(SignUpRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
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
        $credentials = $request->only('phone', 'password');
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
    public function getProfileData(){
        $user=auth('api')->user();
        return $this->responseSuccess(data: UserProfileDataResource::make($user));
    }
    public function updateProfileData($request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            if ($request->image != null)
                $data['image'] = $this->fileManagerService->upload('image', 'users');
            if ($request->cover != null)
                $data['cover'] = $this->fileManagerService->upload('cover', 'users');
            auth('api')->user()->update($data);
            DB::commit();
            return $this->responseSuccess(message: __('messages.updated successfully'));
        } catch (Exception $e) {
            DB::rollBack();
//            dd($e);
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
}
