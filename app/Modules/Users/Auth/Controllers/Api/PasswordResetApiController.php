<?php

declare(strict_types = 1);

namespace App\Modules\Users\Auth\Controllers\Api;

use App\Modules\BaseApp\Api\BaseApiController;
use App\Modules\BaseApp\Enums\ResourceTypesEnums;
use App\Modules\Users\Auth\Requests\api\ConfirmResetCodeRequest;
use App\Modules\Users\Auth\Requests\api\ResetUserPasswordRequest;
use App\Modules\Users\Auth\Requests\api\SendResetPasswordCodeRequest;
use App\Modules\Users\Transformers\ResetPasswordLinkTransformer;
use App\Modules\Users\UseCases\ForgetPasswordUseCase;
use Swis\JsonApi\Client\Interfaces\ParserInterface;

class PasswordResetApiController extends BaseApiController
{
    public function __construct(
        private ParserInterface $parserInterface,
    )
    {
    }

    public function sendCode(SendResetPasswordCodeRequest $request)
    {
        $data = $request->getContent();
        $data = $this->parserInterface->deserialize($data);
        $data = $data->getData();
        $useCase = (new ForgetPasswordUseCase())->sendPasswordResetCode(identifier: $data->identifier);
        if ($useCase['status'] == 200) {
            return $this->successResponse(
                [
                'meta' => ['message' => $useCase['detail']],
                'otp' => $useCase['user']?->otp
                ]
            );
        }
        return formatErrorValidation(
            [
            'status' => $useCase['status'],
            'title' => $useCase['title'],
            'detail' => $useCase['detail']
            ]
        );
    }

    public function confirmCode(ConfirmResetCodeRequest $request)
    {
        $data = $request->getContent();
        $data = $this->parserInterface->deserialize($data);
        $data = $data->getData();
        $useCase = (new ForgetPasswordUseCase())->confirmResetPasswordCode(otp: $data->otp);
        if ($useCase['status'] == 200) {
            return $this->transformDataModInclude(
                [$useCase['data']],
                '',
                new ResetPasswordLinkTransformer(),
                ResourceTypesEnums::RESET_PASSWORD,
                ['detail' => $useCase['detail']]
            );
        }
        return formatErrorValidation(
            [
            'status' => $useCase['status'],
            'title' => $useCase['title'],
            'detail' => $useCase['detail']
            ]
        );
    }

    public function resetUserPassword(ResetUserPasswordRequest $request, $token)
    {
        $data = $request->getContent();
        $data = $this->parserInterface->deserialize($data);
        $data = $data->getData();
        $dataArray = ['password' => $data->password];
        $useCase = (new ForgetPasswordUseCase())->updatePasswordUsingResetToken(
            $token,
            $dataArray,
        );

        if ($useCase['status'] == 200) {
            return $this->successResponse(['meta' => ['detail' => $useCase['detail']]]);
        } else {
            $error = [
                'status' => 422,
                'title' => $useCase['title'],
                'detail' => $useCase['detail']
            ];
            return formatErrorValidation($error);
        }
    }
}
