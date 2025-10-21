<?php

declare(strict_types=1);

namespace App\Modules\Config\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\BaseApp\Enums\ParentEnum;
use App\Modules\Config\Config;
use App\Modules\Config\Repository\ConfigRepository;
use App\Modules\Config\Requests\ConfigRequest;

class ConfigsController extends Controller
{
    private string $module;
    private string $parent;
    private string $title;
    private ConfigRepository $configRepo;

    public function __construct(ConfigRepository $configRepo)
    {
        $this->module = 'configs';
        $this->title = trans('app.Configs');
        $this->parent = ParentEnum::ADMIN;
        $this->configRepo = $configRepo;
    }

    public function getEdit()
    {
        $data['page_title'] = trans('app.Edit') . " " . $this->title;
        $data['row'] = $this->configRepo->get();
        $data['working_days'] = json_decode($data['row']['clinic_working_hours'] ?? '[]', true);

        return view($this->parent . '.' . $this->module . '.edit', $data);
    }

    public function postEdit(ConfigRequest $request)
    {
        $working_days = [];
        foreach ($request->input('working_days', []) as $day => $details) {
            if (!empty($details['day'])) {
                $working_days[$day] = [
                    'day' => true,
                    'from_time' => $details['from_time'] ?? null,
                    'to_time' => $details['to_time'] ?? null,
                ];
            }
        }

        $data = [
            'clinic_name' => $request->input('clinic_name'),
            'clinic_address' => $request->input('clinic_address'),
            'clinic_phone' => $request->input('clinic_phone'),
            'clinic_email' => $request->input('clinic_email'),
            'clinic_latitude' => $request->input('clinic_latitude'),
            'clinic_longitude' => $request->input('clinic_longitude'),
            'clinic_working_hours' => json_encode($working_days, JSON_UNESCAPED_UNICODE),
        ];

        foreach ($data as $key => $value) {
            Config::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        flash('Clinic settings updated successfully.')->success();
        return redirect()->route('admin.configs.get.edit')->with('success', 'Clinic settings updated successfully.');
    }

}
