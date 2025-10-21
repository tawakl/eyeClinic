<?php

namespace App\Modules\WorkingHours\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\WorkingHours\ClinicClosingPeriod;
use Illuminate\Http\Request;

class ClinicClosingPeriodsController extends Controller
{
    public function edit()
    {
        $data['page_title'] = 'Clinic Closing Period';
        $data['row'] = ClinicClosingPeriod::first();
        return view('admin.clinic_closing_periods.edit', $data);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'from_date' => 'required|date',
            'to_date'   => 'required|date|after_or_equal:from_date',
            'reason'    => 'nullable|string|max:255',
        ]);

        ClinicClosingPeriod::updateOrCreate(['id' => 1], $validated);

        flash('Clinic closing period updated successfully.')->success();
        return redirect()->route('admin.clinicClosingPeriods.edit');
    }
}
