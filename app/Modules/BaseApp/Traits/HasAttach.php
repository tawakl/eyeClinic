<?php

declare(strict_types = 1);

namespace App\Modules\BaseApp\Traits;

use App\Modules\BaseApp\Enums\S3Enums;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HasAttach
{

    public static function bootHasAttach()
    {
        static::saved(
            function ($model) {
                $model->autoUpload();
            }
        );
        static::deleted(
            function ($model) {
                $model->autoDelete();
            }
        );
    }

    protected function autoUpload()
    {
        if (isset(static::$attachFields)) {
            $fields = static::$attachFields;
            foreach ($fields as $field => $value) {
                if (isset($value['rules'])) {
                    $this->validateImage(request()->file($field), $field, $value['rules']);
                }
                $oldFile = $this->getOriginal($field);
                //////////////////// upload
                if (request()->hasFile($field) && request()->file($field)->isValid()) {
                    $uploadPath = (@$value['path']) ?: S3Enums::UPLOADS_PATH;
                    $modulePath = (@$value['modulePath']) ?: '/';
                    $image = request()->file($field);
                    $fileName = strtolower(Str::random(10)) . time() . '.' . $image->getClientOriginalExtension();
                    Storage::putFileAs($uploadPath, $image, $fileName);
                    $filePath = $uploadPath . $fileName;
                    /////////////////////// resize
                    if ($filePath) {
                        $imageSizes = @$value['sizes'];

                        if ($imageSizes) {
                            foreach ($imageSizes as $key => $size) {
                                $size = explode(',', $size);
                                $type = $size[0];
                                $dimensions = explode('x', $size[1]);
                                $thumbPath = $uploadPath . $key . '/' . $modulePath . '/' . $fileName;
                                if (!Storage::exists($thumbPath)) {
                                    reSizeImage(
                                        $filePath,
                                        $dimensions[0],
                                        $dimensions[1],
                                        $image->getClientOriginalExtension(),
                                        $thumbPath,
                                        $type
                                    );
                                }
                            }
                            deleteImagePath($filePath);
                        }
                    }
                    ///////////////////////////////////// Delete Old file
                    if ($oldFile) {
                        $this->deleteFile($oldFile, $uploadPath);
                    }
                    //////////////////////////////////// Update Model
                    $this->updateModel($field, $modulePath . '/' . $fileName);
                }
            }
        }
    }

    protected function validateImage($file, $fieldName, $rules)
    {
        if ($rules) {
            $this->validationFactory()->make(
                [$fieldName => $file],
                [$fieldName => $rules]
            )->validate();
        }
    }

    protected function validationFactory()
    {
        return app(Factory::class);
    }

    protected function deleteFile($file_name = "", $path = "app/public/uploads")
    {
        $path = $path . '/';
        if (!@$file_name) {
            return false;
        }
        deleteImagePath($path . $file_name);
    }

    private function exploreDirectory($dirPath)
    {
        if ($handle = @opendir($dirPath)) {
            while (false !== ($file = @readdir($handle))) {
                if ($file != "." && $file != "..") {
                    if (@is_dir("$dirPath/$file")) {
                        $arr[] = "$file";
                    }
                }
            }
            closedir($handle);
        }
        if (@$arr) {
            return $arr;
        }
    }

    protected function updateModel($field, $fileName)
    {
        $this->attributes[$field] = $fileName;
        $dispatcher = $this->getEventDispatcher();
        self::unsetEventDispatcher();
        $this->save();
        self::setEventDispatcher($dispatcher);
    }
}
