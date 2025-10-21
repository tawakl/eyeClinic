<?php

namespace App\Modules\Config;

use App\Modules\BaseApp\BaseModel;

class Config extends BaseModel {

    protected $table = "configs";


    protected $fillable = ['key', 'value'];


}
