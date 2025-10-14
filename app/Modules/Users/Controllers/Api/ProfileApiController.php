<?php

declare(strict_types = 1);

namespace App\Modules\Users\Controllers\Api;

use App\Exceptions\OurEduErrorException;
use App\Modules\BaseApp\Api\BaseApiController;
use App\Modules\BaseApp\Enums\ResourceTypesEnums;
use App\Modules\Users\Auth\Enum\DeletedByEnum;
use App\Modules\Users\Auth\PassportTokenManager;
use App\Modules\Users\Events\UserModified;
use App\Modules\Users\Models\DeleteUserLog;
use App\Modules\Users\Repository\FirebaseTokenRepository;
use App\Modules\Users\Repository\UserRepository;
use App\Modules\Users\Requests\Api\DeleteProfileRequest;
use App\Modules\Users\Requests\Api\UpdatePasswordRequest;
use App\Modules\Users\Requests\Api\UpdateProfileRequest;
use App\Modules\Users\Transformers\UserTransformer;
use App\Modules\Users\UseCases\UpdateProfileUseCase\UpdateProfileUseCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Swis\JsonApi\Client\Interfaces\ParserInterface;
use Throwable;

class ProfileApiController extends BaseApiController
{
    private $parserInterface;

    public function __construct(
        ParserInterface $parserInterface,
    )
    {
        $this->parserInterface = $parserInterface;
    }

    public function getProfile()
    {
        $user = \auth()->guard('api')->user();
        $include = '';
        $params = [];
        $include = [$include, 'actions'];

        return $this->transformDataModInclude($user, $include, new UserTransformer(), ResourceTypesEnums::USER);
    }

    public function postUpdateProfile(UpdateProfileRequest $request)
    {
        $row = auth()->guard('api')->user();
        $data = $request->getContent();
        $data = $this->parserInterface->deserialize($data);
        $data = $data->getData();
        $update = [];
        $update['first_name'] = $data->first_name;
        $update['last_name'] = $data->last_name;
        if (isset($data->mobile) && $data->mobile !== $row->mobile) {
            if (!isset($data->old_password) || !Hash::check($data->old_password, $row->password)) {
                $error = [
                    'status' => 422,
                    'title' => "Old password is required and must be correct to change the mobile number",
                    'detail' =>trans('profile.Old password is required and must be correct to change the mobile number')
                ];
                return formatErrorValidation($error, 422);
            }
            $update['mobile'] = $data->mobile;
        }
        $update['email'] = $data->email;

        if (!empty($data->attach_media)) {
            $mediaCollection = collect($data->attach_media);
            if ($mediaCollection->isNotEmpty()) {
                $update['profile_picture'] = $data->attach_media->first()->getId();
            }
        }
        if (isset($data->old_password) && !is_null($data->old_password)) {
            $update['old_password'] = $data->old_password;
        }
        $userRepository = new UserRepository();
        $updateProfileUseCase = new UpdateProfileUseCase();
        $update = $updateProfileUseCase->updateProfile($update, $userRepository);
        if ($update['code'] == 200) {
            UserModified::dispatch($data->toArray(), \auth()->guard('api')->user()->toArray(), 'User updated profile');
            return $this->transformDataModInclude(
                $update['user'],
                'actions',
                new UserTransformer(),
                ResourceTypesEnums::USER,
                ['message' => $update['message']]
            );
        } else {
            $error = [
                'status' => $update['code'],
                'title' => $update['title'],
                'detail' => $update['message']
            ];
            return formatErrorValidation($error, $update['code']);
        }
    }

    public function postUpdatePassword(UpdatePasswordRequest $request)
    {
        $data = $request->getContent();
        $data = $this->parserInterface->deserialize($data);
        $data = $data->getData();
        try {
            $update = [];
            $update['old_password'] = $data->old_password;
            $update['password'] = $data->password;
            $userRepository = new UserRepository();
            $updateProfileUseCase = new UpdateProfileUseCase();
            $update = $updateProfileUseCase->updatePassword($update, $userRepository);
            if ($update['code'] == 200) {
                UserModified::dispatch(
                    $data->toArray(),
                    \auth()->guard('api')->user()->toArray(),
                    'User updated profile'
                );
                $meta = [
                    'message' => trans('profile.Updated successfully')
                ];

                return response()->json(['meta' => $meta], 200);
            } else {
                $error = [
                    'status' => $update['code'],
                    'title' => $update['title'],
                    'detail' => $update['message']
                ];
                return formatErrorValidation($error, $update['code']);
            }
        } catch (\Throwable $e) {
            Log::error('error in postUpdatePassword', $e);
            throw new OurEduErrorException($e->getMessage());
        }
    }

    public function deleteProfile(DeleteProfileRequest $request)
    {
        $data = $request->getContent();
        $data = $this->parserInterface->deserialize($data);
        $data = $data->getData();
        try {
            $user = \auth()->guard('api')->user();
            $useCase = (new UpdateProfileUseCase())->deleteProfile($data, $user);
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
}
