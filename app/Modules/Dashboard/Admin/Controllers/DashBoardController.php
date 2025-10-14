<?php

declare(strict_types = 1);

namespace App\Modules\Dashboard\Admin\Controllers;

use App\Modules\BaseApp\Controllers\BaseController;

class DashBoardController extends BaseController
{
    public $module;
    private $parent;

    public function __construct()
    {
        $this->module = 'dashboard';
        $this->parent = 'admin';
    }

    public function getIndex()
    {
        $data['breadcrumb'] = '';
        return view($this->parent . '.' . $this->module . '.index', $data);
    }
}
