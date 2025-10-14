<?php

declare(strict_types = 1);

namespace App\Modules\Users\UseCases;

use App\Modules\Users\Auth\PassportTokenManager;
use App\Modules\Users\Repository\FirebaseTokenRepository;
use Illuminate\Support\Facades\Auth;
use Swis\JsonApi\Client\Interfaces\ParserInterface;


class LogoutUseCase
{
    protected $parserInterface;

    public function __construct(

        ParserInterface $parserInterface
    ) {

        $this->parserInterface = $parserInterface;
    }
    public function logout($request)
    {
        $user = Auth::guard('api')->user();
        $data = $request->getContent();
        $data = $this->parserInterface->deserialize($data);
        $data = $data->getData();

        try {
            $data = $data->toJsonApiArray();
            unset($data['type']);

            (new FirebaseTokenRepository())->delete($user, $data);

            (new PassportTokenManager())->revokeAuthAccessToken();

            return [
                "meta" => [
                    'message' => trans('api.Successfully Logged Out')
                ]
            ];
        } catch (\Exception $e) {
            $errorArray = [
                'status' => $e->getCode(),
                'title' => $e->getMessage(),
                'detail' => $e->getTrace()
            ];
            throw new \Exception(json_encode($errorArray), 500);
        }
    }
}
