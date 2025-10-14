<?php

declare(strict_types = 1);

namespace App\Modules\Users\UseCases;


use App\Modules\Users\Jobs\SendActivationCode;
use App\Modules\Users\Repository\UserRepository;
use App\Modules\Users\User;
use App\Modules\Users\UserEnums;
use Illuminate\Support\Facades\Cache;

class SendLoginOtpUseCase
{

    public function send(User $user)
    {
        $this->sendActivationCode($user);

    }
    public function reSend(
        String $identifier,
    )
    {
        $user =null;
        if (preg_match(UserEnums::USER_MOBILE_REGEX, $identifier)) {
            $user = (new UserRepository())->findByMobile($identifier);

        }
        $errors = $this->validateResendOTP($user);

        if (count($errors)){
            return $errors;
        }

        $this->sendActivationCode($user);

        Cache::remember("user_{$user->id}_otp", now()->addSeconds(30), function () {
            return 1;
        });
        $user->refresh();
        $useCase['user'] =$user ;
        $useCase['code'] = 200;
        $useCase['title'] = "otp has been sent to your mobile";
        $useCase['detail'] = trans('auth.otp has been sent to your  mobile');
        return $useCase;
    }

    private function validateResendOTP($user): array
    {
        $useCase =[];
        if (!$user){
            $useCase['user'] = null;
            $useCase['title'] = 'There is no account with this Mobile';
            $useCase['detail'] = trans('auth.There is no account with this Mobile');
            $useCase['code'] = 422;
            return $useCase;
        }
        if ($user->confirmed){
            $useCase['user'] = $user;
            $useCase['title'] = 'This account already confirmed';
            $useCase['detail'] = trans('auth.This account already confirmed');
            $useCase['code'] = 422;

            return $useCase;
        }
        if (Cache::has("user_{$user->id}_otp")) {
            $useCase['title'] = trans('You may request password reset token once every 30 seconds');
            $useCase['detail'] = trans('auth.You may request password reset token once every 30 seconds');
            $useCase['code'] = 422;
            return $useCase;
        }
        return $useCase;
    }
    private function sendActivationCode(User $user)
    {
        $notificationData = [
            'users' => collect([$user]),
            'sms' => [
                'message' => 'app.Activate Code'
            ]
        ];


        SendActivationCode::dispatch($user, $notificationData);
    }
}
