<?php

declare(strict_types = 1);

namespace App\Modules\Users\UseCases\UpdateProfileUseCase;

use App\Modules\Users\Auth\Enum\DeletedByEnum;
use App\Modules\Users\Auth\PassportTokenManager;
use App\Modules\Users\Repository\DeleteUserLogRepository;
use App\Modules\Users\Repository\FirebaseTokenRepository;
use App\Modules\Users\Repository\UserRepository;

use App\Modules\Users\UserEnums;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UpdateProfileUseCase
{
    public function __construct()
    {
    }

    /**
     * @param array $data
     * @param UserRepository $userRepository
     * @return array
     */
    public function updateProfile(array $data, UserRepository $userRepository): array
    {
        $return = [];
        $auth = checkLoginGuard();
        $user = $userRepository->findOrFail($auth->id());

        if (array_key_exists('password', $data) && isset($data['old_password'])) {
            if (array_key_exists('old_password', $data)) {
                if (!Hash::check(trim($data['old_password']), trim($user->password))) {
                    $return['code'] = 422;
                    $return['message'] = trans('api.Wrong old Password');
                    $return['title'] = 'Wrong old Password';
                    return $return;
                }
            } else {
                $return['code'] = 422;
                $return['message'] = trans('api.Old Password required');
                $return['title'] = 'Wrong old Password';
                return $return;
            }
        }
        if (!(isset($data['email']) && filter_var($data['email'], FILTER_VALIDATE_EMAIL))) {
            $data['email'] = $user->email;
        }

        if (!(isset($data['mobile']) && preg_match(UserEnums::USER_MOBILE_REGEX, $data['mobile']))) {
            $data['mobile'] = $user->mobile;
        }
        if ($user->mobile != $data['mobile']) {
            if (array_key_exists('old_password', $data) && strlen($data['old_password']) > 0) {
                if (!Hash::check(trim($data['old_password']), trim($user->password))) {
                    $return['code'] = 422;
                    $return['title'] = 'Wrong old Password';
                    $return['message'] = trans('api.Wrong old Password');
                    return $return;
                }
            } else {
                $return['code'] = 422;
                $return['title'] = 'Old Password required';
                $return['message'] = trans('validation.required', ['attribute' => trans('validation.password')]);
                return $return;
            }
        }
        if ($userRepository->updateUser($user, $data)) {
            if (auth('api')->check() && isset($data['profile_picture'])) {
                $pic = null;
                try {
                    $pic = moveSingleGarbageMedia($data['profile_picture'], 'profiles');
                }catch (\Throwable $exception){
                    Log::error('updating profile pic' ,[
                        'exp' => $exception->getMessage(),
                        'exp trac' => $exception->getTrace()
                    ]);
                }
                $data['profile_picture'] = $pic;
            } elseif (isset($data['profile_picture'])) {
                $data['profile_picture'] = 'profiles/' . $user->fresh()->profile_picture;
            }
            $userRepository->updateUser($user, $data);
            //Todo: update zoom user
//            if ($user->type == UserEnums::STUDENT_TYPE) {
//                $zoomAccount = $user->zoom;
//                if (!$zoomAccount) {
//                    $this->createZoomUserUseCase->createUser($user);
//                    $zoomAccount = $user->zoom;
//                }
//
//                if ($user->isDirty("profile_picture")) {
//                    $this->createZoomUserUseCase->changeProfilePicture($zoomAccount->zoom_id, $user->profile_picture);
//                }
//            }

            $return['code'] = 200;
            $return['message'] = trans('app.Update successfully');
            $return['user'] = $userRepository->findOrFail($auth->id());
            return $return;
        }
        $return['code'] = 500;
        $return['message'] = trans('app.Oopps Something is broken');
        $return['title'] = 'Oopps Something is broken';
        return $return;
    }

    public function updatePassword(array $data, UserRepository $userRepository): array
    {
        $return = [];

        $auth = checkLoginGuard();
        $user = $userRepository->findOrFail($auth->id());
        if (is_null($data['old_password'])) {
            if ($user->confirm_token) {
                if ($userRepository->updateUser($user, $data)) {
                    $userRepository->updateUser($user, ['confirm_token' => null]);
                    $return['code'] = 200;
                    $return['message'] = trans('app.Update successfully');
                    $return['user'] = $user;
                    return $return;
                }
            } else {
                $return['code'] = 422;
                $return['message'] = trans('api.Old Password required');
                $return['title'] = 'Old Password required';
                return $return;
            }
        }
        if (array_key_exists('password', $data) && isset($data['old_password'])) {
            if (array_key_exists('old_password', $data)) {
                if (!Hash::check(trim($data['old_password']), trim($user->password))) {
                    $return['code'] = 422;
                    $return['message'] = trans('api.Wrong old Password');
                    $return['title'] = 'Wrong old Password';
                    return $return;
                }
            } else {
                $return['code'] = 422;
                $return['message'] = trans('api.Old Password required');
                $return['title'] = 'Old Password required';
                return $return;
            }
        }
        if ($userRepository->updateUser($user, $data)) {
            $return['code'] = 200;
            $return['message'] = trans('app.Update successfully');
            $return['user'] = $userRepository->findOrFail($auth->id());
            return $return;
        }
        $return['code'] = 500;
        $return['message'] = trans('app.Oopps Something is broken');
        $return['title'] = 'Oopps Something is broken';
        return $return;
    }

    public function deleteProfile($data, $user)
    {
        if (Hash::check(trim($data->old_password), trim($user->password))) {
            (new FirebaseTokenRepository())->delete($user, ['user_id' => $user->id]);
            (new PassportTokenManager())->revokeAuthAccessToken();
            (new UserRepository())->updateUser($user, ['deleted_by_user_action' => 1]);
            (new DeleteUserLogRepository())->logUserDeletion($user->id, DeletedByEnum::DELETED_BY_USER);
            $return = [
                'code' => 200,
                'message' => trans('api.Profile Deleted Successfully'),
                'title' => 'Profile Deleted Successfully'
            ];
        } else {
            $return = [
                'code' => 422,
                'message' => trans('api.Wrong old Password'),
                'title' => 'Wrong old Password'
            ];
        }
        return $return;
    }
}
