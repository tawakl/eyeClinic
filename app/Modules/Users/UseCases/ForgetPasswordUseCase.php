<?php

declare(strict_types = 1);

namespace App\Modules\Users\UseCases;

use App\Modules\BaseNotification\NotifierFactory\NotifierFactory;
use App\Modules\Users\Auth\Enum\ResetPasswordEnum;
use App\Modules\Users\Jobs\SendActivationCode;
use App\Modules\Users\Repository\PasswordResetRepository;
use App\Modules\Users\Repository\UserRepository;
use App\Modules\Users\User;
use App\Modules\Users\UserEnums;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ForgetPasswordUseCase
{
    public function sendPasswordResetCode(
        string $identifier,
    ): array {
        $return = [];
        $userRepository = new UserRepository();
        $user = $userRepository->findByCol(col: UserEnums::USER_LOGIN_MOBILE_TYPE, key: $identifier);
        $errors = $this->validateSendPasswordResetCode($identifier, $user);
        if ($errors) {
            return $errors;
        }
        $passwordResetRepository = new PasswordResetRepository();
        $passwordResetRepository->deleteByCol(
            col: UserEnums::USER_LOGIN_MOBILE_TYPE,
            key: $identifier
        );
        $token = Str::random(60);
        $resetPassword = [UserEnums::USER_LOGIN_MOBILE_TYPE => $user->mobile, 'token' => $token, date('Y-m-d')];
        $password = $passwordResetRepository->create($resetPassword);
        if ($password) {
            $notificationData = [
                'users' => collect([$user]),
                'sms' => [
                    'message' => 'app.Activate Code'
                ]
            ];
            SendActivationCode::dispatch(user: $user, notificationData: $notificationData);
            Cache::remember("user_{$user->id}_reset_mail", now()->addSeconds(30), function () {
                return 1;
            });

            $return['user'] = $user->refresh();
            $return['status'] = 200;
            $return['detail'] = __('auth.Password reset token has been sent');
            return $return;
        }

        $return['status'] = 500;
        $return['detail'] = __('app.Oopps Something is broken');
        return $return;
    }

    public function confirmResetPasswordCode(string $otp): array
    {
        try {
            $user = (new UserRepository())->findByCol('otp', $otp);
            $token = (new PasswordResetRepository())->findByCol(UserEnums::USER_LOGIN_MOBILE_TYPE, $user->mobile);
            if ($token) {
                $url = (new ResetPasswordEnum($token->token))->getTypeLink($user->type);
                $data = [
                    'url' => $url,
                    'token' => $token->token
                ];
                $user->update(['otp' => null]);
                return [
                    'status' => 200,
                    'data' => $data,
                    'detail' => __('auth.change password Now')
                ];
            } else {
                return [
                    'status' => 422,
                    'title' => __('auth.Unknown Password Request'),
                    'detail' => __('auth.Unknown Password Request')
                ];
            }
        } catch (\Exception $exception) {
            Log::error(
                'error in confirming reset password code',
                ['error' => $exception->getMessage()]
            );
            return [
                'status' => 500,
                'title' => __('Ooops Something is broken'),
                'detail' => __('app.Ooops Something is broken')
            ];
        }
    }

    public function updatePasswordUsingResetToken(
        string $token,
        array $data,
    ) {
        $passwordReset = (new PasswordResetRepository())->findByCol('token', $token);

        if (is_null($passwordReset)) {
            $return['status'] = 422;
            $return['title'] = 'Unknown Password Request';
            $return['detail'] = __('auth.Unknown Password Request');
            return $return;
        }

        $user = (new UserRepository())->findByCol(UserEnums::USER_LOGIN_MOBILE_TYPE, $passwordReset->mobile);
        if (!$user) {
            $return['status'] = 422;
            $return['title'] = __('auth.Unknown Password Request');
            $return['detail'] = __('auth.Unknown Password Request');
            return $return;
        }
        $user->update([
            'password' => $data['password'],
            'otp' => null,
        ]);
        (new PasswordResetRepository())->deleteByCol('token', $token);

        $return['status'] = 200;
        $return['title'] = 'Password Changed Successfully';
        $return['detail'] = __('auth.Password Changed Successfully');
        $return['user'] = $user;
        return $return;
    }

    private function validateSendPasswordResetCode(
        string $identifier,
        User|null $user
    ) {
        if (!preg_match(UserEnums::USER_MOBILE_REGEX, $identifier)) {
            $return['status'] = 422;
            $return['title'] = 'Invalid mobile format';
            $return['detail'] = __('auth.you must enter a valid or mobile');
            return $return;
        }

        if (!$user) {
            $return['status'] = 422;
            $return['title'] = 'There is no account with this mobile';
            $return['detail'] = __('auth.user not found');
            return $return;
        }

        if (Cache::has("user_{$user->id}_reset_mail")) {
            $return['status'] = 422;
            $return['title'] = 'You may request password reset token once every 30 seconds';
            $return['detail'] = __('auth.You may request password reset token once every 30 seconds');
            return $return;
        }
    }

    public function sendPasswordResetMail(
        string $email,
    ): array {
        $return = [];
        // find user
        $userRepository = new UserRepository();
        $user = $userRepository->findByCol('email', $email);

        if (!$user) {
            $return['message'] = trans('auth.Unknown Password Request');
            $return['code'] = 422;
            return $return;
        }
        if ($user->deleted_by_user_action) {
            $return['user'] = null;
            $return['message'] = 'This account is suspended';
            $return['detail'] = trans('auth.This account is suspended');
            return $return;
        }

        if (Cache::has("user_{$user->id}_reset_mail")) {
            $return['message'] = trans('auth.You may request password reset token once every 3 minutes');
            $return['code'] = 422;
            return $return;
        } else {
            // generate token
            $token = Str::random(60);

            // store token
            $resetPassword = ['email' => $user->email, 'token' => $token, date('Y-m-d')];
            $password = $userRepository->createResetPassword($resetPassword);

            if ($password) {
                $url = new ResetPasswordEnum($user, $token);
                $url = $url->getTypeLink($user->type);

                $notificationData = [
                    'users' => collect([$user]),
                    'mail' => [
                        'user_type' => $user->type,
                        'data' => ['url' => $url, 'lang' => $user->language],
                        'subject' => trans('app.OurEdu password reset mail', [], $user->language),
                        'view' => 'passwordResetMail'
                    ]
                ];
                $notificationFactory = app(NotifierFactory::class);
                $notificationFactory->send($notificationData);

                Cache::remember("user_{$user->id}_reset_mail", now()->addMinutes(2), function () {
                    return 1;
                });
                $return['user'] = $user;
                $return['code'] = 200;
                $return['message'] = trans('auth.Password reset token has been sent to your mail');
                return $return;
            }
        }
        return $return;
    }
}
