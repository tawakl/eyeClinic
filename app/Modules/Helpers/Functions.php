<?php

declare(strict_types = 1);

use App\Modules\BaseApp\Enums\S3Enums;
use App\Modules\GarbageMedia\GarbageMedia;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use App\Modules\PaymentTransactions\Enums\PaymentEnums;
use Carbon\Carbon;
use Illuminate\Support\Str;

if (!function_exists('appName')) {
    function appName(): string
    {
        return "";
    }
}
if (!function_exists('unauthorized')) {
    function unauthorized()
    {
        throw new HttpResponseException(
            response()->json(
                [
                    "errors" => [
                        [
                            'status' => 403,
                            'title' => 'unauthorized_action',
                            'detail' => trans('app.Unauthorized action')
                        ]
                    ]

                ],
                403
            )
        );
    }
}
if (!function_exists('formatErrorValidation')) {
    /**
     *  JsonApi Error format Validation
     * @param array $errors
     * @param int $code
     */
    function formatErrorValidation(array $errors, int $code = 422): \Illuminate\Http\JsonResponse
    {
        $errorsArray = [];
        foreach ($errors as $error) {
            if (is_array($error)) {
                $errorsArray[] = [
                    'status' => $error['status'],
                    'title' => Str::snake($error['title']),
                    'detail' => $error['detail'],
                ];
            } else {
                $errorsArray[] = [
                    'status' => $errors['status'],
                    'title' => Str::snake($error['title']),
                    'detail' => $errors['detail'],
                ];
                break;
            }
        }
        return response()->json(["errors" => $errorsArray], $code);
    }
}
if (!function_exists('getDynamicLink')) {
    function getDynamicLink($link, $params = [])
    {
        foreach ($params as $key => $value) {
            $link = str_replace('{' . $key . '}', (string)$value, $link);
        }
        return ($link);
    }
}
if (!function_exists("getActiveElementByRoute")) {
    function getActiveElementByRoute($route): string
    {
        return $route == Route::currentRouteName() ? "active" : "";
    }
}
if (!function_exists('reSizeImage')) {
    function reSizeImage($pathFrom, $width, $height, $imageExt, $pathTo, $resizeType)
    {
        if (Storage::exists($pathFrom)) {
            $image = Intervention\Image\Facades\Image::make(getImageToMake($pathFrom));
            if ($resizeType == S3Enums::RESIZE) {
                $image->resize(
                    $width,
                    $height,
                    function ($constraint) {
                        $constraint->aspectRatio();
                    }
                );
            } elseif ($resizeType == S3Enums::CROP) {
                $image->fit($width, $height);
            }
            $image->encode($imageExt, 60);
            Storage::put($pathTo, $image->__toString());
        }
    }
}
if (!function_exists('getFilePath')) {
    function getFilePath($imagePath, $alt = null)
    {
        try {
            if (Storage::get($imagePath)) {
                return Storage::path($imagePath);
            }
        } catch (Exception $exception) {
            if ($alt) {
                return $alt;
            }
            return url("/assets/img/avatar.png");
        }
        return url("/assets/img/avatar.png");
    }
}
if (!function_exists('getFileUrl')) {
    function getFileUrl($imagePath, $alt = null)
    {
        try {
            if (Storage::get($imagePath)) {
                return Storage::url($imagePath);
            }
        } catch (Exception $exception) {
            if ($alt) {
                return $alt;
            }
            return url("/assets/img/avatar.png");
        }
        return url("/assets/img/avatar.png");
    }
}
if (!function_exists('deleteImagePath')) {
    function deleteImagePath($imagePath): void
    {
        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }
    }
}
if (!function_exists('moveImagePath')) {
    function moveImagePath($pathFrom, $pathTo, $storagePath, $fileName)
    {
        if (!in_array($pathTo . $storagePath, Storage::allDirectories())) {
            Storage::put($pathTo . $storagePath . '.gitkeep', '');

        }
        Storage::move($pathFrom . $fileName, $pathTo . $storagePath . '/' . $fileName);
    }
}
if (!function_exists('getImageSize')) {
    function getImageSize($imagePath)
    {
        if (Storage::exists($imagePath)) {
            return Storage::size($imagePath);
        }
        return 0;
    }
}
if (!function_exists('viewImage')) {
    function viewImage($img, $type, $attributes = null)
    {
        $width = 200;
        if ($attributes) {
            $width = @$attributes['width'];
            $class = @$attributes['class'];
            $id = @$attributes['id'];
        }
        $src = image($img, $type);
        return '<img  width="' . $width . '" src="' . $src . '" class="' . @$class . '" id="' . @$id . '" >';
    }
}
if (!function_exists('viewVideo')) {
    function viewVideo($vid, $attributes = null)
    {
        $width = 200;
        if ($attributes) {
            $width = @$attributes['width'];
        }
        $src = getFileUrl(S3Enums::UPLOADS_PATH . $vid, url("/assets/img/avatar.png"));
        return '<video width="' . $width . '" height="' . $width . '" controls>
                        <source src="' . $src . '" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>';
    }
}
if (!function_exists('viewFile')) {
    function viewFile($file, $folder = 'uploads', $placeholder = null)
    {
        $path = $folder . '/' . $file;
        $path = getFileUrl($path, '');
        return '<i class="fa fa-paperclip"></i> <a href="' . $path . '" target="_blank" >' . $placeholder ?? $file . '</a>';
    }
}
if (!function_exists('image')) {
    function image($img, $type = null, $folder = S3Enums::UPLOADS_PATH)
    {
        $path = $folder;
        if (!empty($type)) {
            $path .= $type . '/';
        }
        $path .= $img;
        return getFileUrl($path, url("/assets/img/avatar.png"));
    }
}
if (!function_exists('getImageTypes')) {
    function getImageTypes()
    {
        return [
            'jpeg',
            'png',
            'jpg',
            'gif',
            'svg'
        ];
    }
}



if (!function_exists('formatFiltersForApi')) {
    function formatFiltersForApi($filters)
    {
        $result = [];
        foreach ($filters as $filter) {
            $filterResult = [];
            if (isset($filter['name'])) {
                $filterResult['name'] = $filter['name'];
            }
            if (isset($filter['type'])) {
                $filterResult['type'] = $filter['type'];
            }
            if (isset($filter['value'])) {
                $filterResult['value'] = $filter['value'];
            } else {
                $filterResult['value'] = null;
            }
            if (isset($filter['data'])) {
                $filterResult['data'] = formatFilter($filter['data']);
            }
            $result[] = $filterResult;
        }

        return $result;
    }
}
if (!function_exists('formatFilter')) {
    function formatFilter($data)
    {
        $arr = [];
        if (is_array($data) && count($data) > 0) {
            foreach ($data as $key => $value) {
                $obj = new \stdClass();
                $obj->key = $key;
                $obj->value = $value;
                $arr[] = $obj;
            }
        }
        return $arr;
    }
}
if (!function_exists('truncateString')) {
    function truncateString($text, $length)
    {
        $length = abs((int)$length);
        if (strlen($text) > $length) {
            $text = preg_replace("/^(.{1,$length})(\s.*|$)/s", '\\1...', $text);
        }
        return ($text);
    }
}
if (!function_exists('buildScopeRoute')) {
    /**
     * build Scope Route
     * @param $route , $param
     * @return string
     */
    function buildScopeRoute($route, array $param = [])
    {
        $params = ['language' => app()->getLocale()];
        if (count($param) > 0) {
            $params = array_merge($params, $param);
        }
        return route($route, $params);
    }
}
if (!function_exists('checkLoginGuard')) {
    function checkLoginGuard()
    {
        if (auth('api')->check()) {
            return auth('api');
        } else {
            return auth();
        }
    }
}
if (!function_exists('urlLang')) {
    function urlLang($url, $fromlang, $toLang)
    {
        return str_replace('/' . $fromlang . '/', '/' . $toLang . '/', strtolower($url));
    }
}
if (!function_exists('lang')) {
    function lang()
    {
        return \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale();
    }
}

if (!function_exists('languages')) {
    function languages()
    {
        $languages = config('laravellocalization.supportedLocales');
        $langs = [];
        foreach ($languages as $key => $value) {
            $langs[$key] = $value['name'];
        }
        return $langs;
    }
}

if (!function_exists('buildTranslationKey')) {
    function buildTranslationKey(string $trans_key, array $trans_params = [])
    {
        if (count($trans_params)) {
            $translation = [
                'trans_key' => $trans_key,
                'trans_params' => $trans_params
            ];
        } else {
            $translation = $trans_key;
        }
        return ($translation);
    }
}

if (!function_exists('displayTranslation')) {
    function displayTranslation($key, $lang = null)
    {
        if (is_array($key)) {
            $translation = trans($key['trans_key'], $key['trans_params'], $lang);
        } else {
            $translation = trans($key, [], $lang);
        }
        return ($translation);
    }
}

if (!function_exists('displayTranslation')) {
    function displayTranslation($key, $lang = null)
    {
        if (is_array($key)) {
            $translation = trans($key['trans_key'], $key['trans_params'], $lang);
        } else {
            $translation = trans($key, [], $lang);
        }
        return ($translation);
    }
}
