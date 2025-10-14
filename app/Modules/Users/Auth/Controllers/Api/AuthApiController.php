<?php

declare(strict_types = 1);

namespace App\Modules\Users\Auth\Controllers\Api;

use App\Exceptions\OurEduErrorException;
use App\Modules\BaseApp\Api\BaseApiController;
use App\Modules\BaseApp\Enums\ResourceTypesEnums;
use App\Modules\Users\Auth\Enum\TokenNameEnum;
use App\Modules\Users\Auth\PassportTokenManager;
use App\Modules\Users\Auth\Requests\api\LogoutRequest;
use App\Modules\Users\Auth\Requests\api\ReactivateProfileRequest;
use App\Modules\Users\Auth\Requests\api\ResendOTPRequest;
use App\Modules\Users\Auth\Requests\api\UserActivateOtpRequest;
use App\Modules\Users\Auth\Requests\api\UserLoginRequest;
use App\Modules\Users\Auth\Requests\api\UserRegisterRequest;
use App\Modules\Users\Transformers\UserTransformer;
use App\Modules\Users\UseCases\ActivateUserUseCase;
use App\Modules\Users\UseCases\LoginUseCase;
use App\Modules\Users\UseCases\LogoutUseCase;
use App\Modules\Users\UseCases\RegisterUseCase;
use App\Modules\Users\UseCases\SendLoginOtpUseCase;
use App\Modules\Users\UserEnums;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Swis\JsonApi\Client\Interfaces\ParserInterface;
use Throwable;


class AuthApiController extends BaseApiController
{
    public function __construct(
        private ParserInterface $parserInterface
    ) {
    }

    public function postLogin(UserLoginRequest $request)
    {
        $data = $request->getContent();
        $data = $this->parserInterface->deserialize($data);
        $data = $data->getData();
        $requestData = [];
        $requestData['loginKey'] = $data->mobile;
        $requestData['password'] = $data->password;
        $requestData['remember_me'] = $data->remember_me;
        $requestData['device_type'] = $data->device_type;
        $useCase = (new LoginUseCase())->login(request: $requestData, attribute: UserEnums::USER_LOGIN_MOBILE_TYPE);
        if ($useCase['status'] == 200) {
            $meta = [
                'token' => (new PassportTokenManager())->createUserToken(
                    identifier: TokenNameEnum::API_TOKEN,
                    user: $useCase['user']
                ),
                'message' => __('api.Successfully Logged In')
            ];
            $include = 'actions';
            //send data to transformer
            return $this->transformDataModInclude(
                $useCase['user'],
                $include,
                new UserTransformer(),
                ResourceTypesEnums::USER,
                $meta
            );
        } else {
            return formatErrorValidation(
                [
                    'status' => $useCase['status'] ?? 422,
                    'title' => $useCase['title'],
                    'detail' => $useCase['detail'],
                ]
            );
        }
    }

    public function postRegister(UserRegisterRequest $request)
    {
        $data = $request->getContent();
        $data = $this->parserInterface->deserialize($data);
        $data = $data->getData();
        $pic = null;
        if (isset($data->attachMedia)) {
            try {
                $pic = moveSingleGarbageMedia(
                    $data->attachMedia['id'],
                    'profiles'
                );
            } catch (\Throwable $exception) {
                Log::error('error on uploading pic' , [
                    'exp' => $exception->getMessage() ,
                    'exp tra' =>$exception->getTrace()
                ]);
            }
        }
        try {
            $requestData = [
                'profile_picture' => $pic,
                'first_name' => $data->first_name,
                'last_name' => $data->last_name,
                'email' => $data->email,
                'mobile' => $data->mobile,
                'password' => $data->password,
                'type' => $data->user_type ?? UserEnums::CLIENT_TYPE,
            ];

            $user = (new RegisterUseCase())->register($requestData);
            $user->refresh();
            if (!is_null($user)) {
                return response()->json(
                    [
                        'message' => trans('api.Thanks for registration')
                    ]
                );
            }
        } catch (\Throwable $e) {
            Log::error('Error in register user: ' . $e->getMessage());
            throw new OurEduErrorException($e->getMessage());
        }
    }

    public function getActivateOtp(UserActivateOtpRequest $request)
    {
        $data = $request->getContent();
        $data = $this->parserInterface->deserialize($data);
        $data = $data->getData();
        $code = $data->otp;

        $user = (new ActivateUserUseCase())->activateWithOtp($code);
        if (!$user) {
            return formatErrorValidation(
                [
                    'status' => 422,
                    'title' => 'invalid code',
                    'detail' => trans('auth.invalid code')
                ]
            );
        }

        return response()->json(
            [
                'message' => trans('api.Account activated')
            ]
        );
    }

    public function resendOtpConfirm(ResendOTPRequest $request)
    {
        $data = $request->getContent();
        $data = $this->parserInterface->deserialize($data);
        $data = $data->getData();

        $useCase = (new SendLoginOtpUseCase())->reSend(
            $data->identifier,
        );
        if ($useCase['code'] == 200) {
            return $this->successResponse(
                ['meta' => ['message' => $useCase['detail']], 'otp' => $useCase['user']?->otp]
            );
        } else {
            $error = [
                'status' => 422,
                'title' => $useCase['title'],
                'detail' => $useCase['detail']
            ];
            return formatErrorValidation($error);
        }
    }

    public function reactivateProfile(ReactivateProfileRequest $request)
    {
        $data = $request->getContent();
        $data = $this->parserInterface->deserialize($data);
        $data = $data->getData();
        try {
            $useCase = (new ActivateUserUseCase())->reActivateProfile($data);
            if ($useCase['code'] == 200) {
                $meta = [
                    'message' => $useCase['message']
                ];
                return response()->json(['meta' => $meta], 200);
            } else {
                $error = [
                    'status' => $useCase['code'],
                    'title' => $useCase['title'],
                    'detail' => $useCase['message']
                ];
                return formatErrorValidation($error, $useCase['code']);
            }
        } catch (Throwable $e) {
            Log::error($e);
            throw new OurEduErrorException($e->getMessage());
        }
    }

    public function postLogout(LogoutRequest $request)
    {
        try {
            $response = (new LogoutUseCase($this->parserInterface))->logout($request);
            return response()->json($response);
        } catch (\Exception $e) {
            $errorArray = [
                'status' => $e->getCode(),
                'title' => $e->getMessage(),
                'detail' => $e->getTrace()
            ];
            return formatErrorValidation($errorArray, 500);
        }
    }
}
