<?php

namespace App\Http\Services\Api\V1\Auth\Password;

use App\Http\Requests\Api\V1\Auth\Password\ResetPasswordRequest;
use App\Http\Resources\V1\Otp\OtpResource;
use App\Http\Traits\Responser;
use App\Jobs\SendingEmail;
use App\Mail\ResetPassword;
use App\Models\User;
use App\Repository\OtpRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordService
{
    use Responser;

    public function __construct(private UserRepositoryInterface $repository, private OtpRepositoryInterface $otpRepository)
    {
    }


    public function forgot($request)
    {
        $user = $this->repository->get('email', $request->email)?->first();
        $user->update([
            'otp_verified' => false
        ]);
        $otp = $this->otpRepository->generateOtp($user);
        // TODO :Sending OTP in email/phone
        return $this->responseSuccess(message: __('messages.OTP code has been sent'), data: new OtpResource($otp));
    }

    public function verifyOtp($request)
    {

        try {
            DB::beginTransaction();
            $data = $request->validated();
            $user = $this->repository->get('email', $request->email)?->first();
            if (!$this->otpRepository->check($data['otp'], $data['otp_token'], $user))
                return $this->responseFail(message: __('messages.Wrong OTP code or expired'));
            $user->otps()?->delete();
            $user->update([
                'otp_verified' => true
            ]);
            $resetToken = Str::random(60);
            Cache::put('reset_token_' . $request->email, $resetToken, now()->addMinutes(10)); // Valid for 10 minutes
            DB::commit();
            return $this->responseSuccess(data: ['reset_token' => $resetToken]);
        } catch (\Exception $e) {
            DB::rollBack();
//            return $e;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function reset($request)
    {

        try {
            DB::beginTransaction();
            $data = $request->validated();
            $cachedToken = Cache::get('reset_token_' . $request->email);
            if (!$cachedToken || $cachedToken != $request->reset_token) {
                return $this->responseFail(message: __('messages.Invalid or expired reset token.'));
            }
            Cache::forget('reset_token_' . $request->email);
            $user = $this->repository->get('email', $request->email)?->first();
            $this->repository->update($user->id, ['password' => $request->password]);
            DB::commit();
            return $this->responseSuccess(message: __('messages.Password reset successfully.'));
        } catch (\Exception $e) {
            DB::rollBack();
//            return $e;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function updatePassword($request)
    {
        $user = auth('api')->user();
        if (Hash::check($request->new_password, $user->password)) {
            return $this->responseFail(message: __('messages.The new password must be different from the current password.'));
        }
        $user = $this->repository->update($user->id, ['password' => $request->new_password]);
        if ($user) {
            return $this->responseSuccess(message: __('messages.updated successfully'));
        } else {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }


}
