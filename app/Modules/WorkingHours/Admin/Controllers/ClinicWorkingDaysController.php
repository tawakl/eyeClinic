<?php

namespace App\Modules\WorkingHours\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\WorkingHours\Admin\Requests\ClinicWorkingDayRequest;
use App\Modules\WorkingHours\ClinicWorkingDay;
use App\Modules\WorkingHours\Repository\ClinicWorkingDayRepository;

class ClinicWorkingDaysController extends Controller
{
    private ClinicWorkingDayRepository $repo;

    public function __construct(ClinicWorkingDayRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $data['page_title'] = trans('clinic_working_days.Clinic Working Days');
        $data['rows'] = $this->repo->all();
        return view('admin.clinic_working_days.edit', $data);
    }


    public function update(ClinicWorkingDayRequest $request)
    {
        $workingDays = $request->input('working_days', []);

        foreach ($workingDays as $data) {
            ClinicWorkingDay::updateOrCreate(
                ['day' => $data['day']],
                [
                    'from_time'     => $data['from_time'] ?? null,
                    'to_time'       => $data['to_time'] ?? null,
                    'break_from'    => $data['break_from'] ?? null,
                    'break_to'      => $data['break_to'] ?? null,
                    'slot_duration' => $data['slot_duration'] ?? 30,
                    'is_active'     => isset($data['is_active']) ? 1 : 0,
                ]
            );
        }

        flash(trans('clinic_working_days.Working days updated successfully.'))->success();
        return redirect()->back();
    }



}
