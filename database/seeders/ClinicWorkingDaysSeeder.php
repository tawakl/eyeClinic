<?php

namespace Database\Seeders;

use App\Modules\WorkingHours\ClinicWorkingDay;
use Illuminate\Database\Seeder;

class ClinicWorkingDaysSeeder extends Seeder
{
    public function run(): void
    {
        $days = [
            'Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'
        ];

        foreach ($days as $day) {
            ClinicWorkingDay::firstOrCreate(
                ['day' => $day],
                [
                    'from_time' => '09:00',
                    'to_time' => '17:00',
                    'break_from' => '13:00',
                    'break_to' => '14:00',
                    'slot_duration' => 30,
                    'is_active' => true,
                ]
            );
        }
    }
}
