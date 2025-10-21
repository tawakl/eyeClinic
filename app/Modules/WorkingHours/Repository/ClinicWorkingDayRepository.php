<?php

declare(strict_types = 1);

namespace App\Modules\WorkingHours\Repository;

use App\Modules\WorkingHours\ClinicWorkingDay;
use Carbon\Carbon;


class ClinicWorkingDayRepository
{
    private ClinicWorkingDay $workingDay;

    public function __construct($workingDay = null)
    {
        if ($workingDay instanceof ClinicWorkingDay) {
            $this->workingDay = $workingDay;
        } else {
            $this->workingDay = new ClinicWorkingDay();
        }
    }

    public function all()
    {
        return $this->workingDay->orderByRaw("FIELD(day, 'Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday')")
            ->get();
    }

    public function updateOrCreate(array $data)
    {
        foreach ($data as $dayData) {
            $this->workingDay->updateOrCreate(
                ['day' => $dayData['day']],
                $dayData
            );
        }
    }

    public function generateSlotsForDay(ClinicWorkingDay $day): array
    {
        if (!$day->from_time || !$day->to_time) return [];

        $slots = [];
        $start = Carbon::createFromTimeString($day->from_time);
        $end = Carbon::createFromTimeString($day->to_time);
        $breakStart = $day->break_from ? Carbon::createFromTimeString($day->break_from) : null;
        $breakEnd = $day->break_to ? Carbon::createFromTimeString($day->break_to) : null;

        while ($start->lt($end)) {
            $slotEnd = (clone $start)->addMinutes($day->slot_duration);

            if ($slotEnd->gt($end)) break;

            $isBreak = $breakStart && $breakEnd && $start->between($breakStart, $breakEnd);

            if (!$isBreak) {
                $slots[] = [
                    'from' => $start->format('H:i'),
                    'to' => $slotEnd->format('H:i')
                ];
            }

            $start->addMinutes($day->slot_duration);
        }

        return $slots;
    }



}
