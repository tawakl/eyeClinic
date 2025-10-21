<?php

namespace App\Modules\LandingPage\Controllers;

use App\Modules\BaseApp\Api\BaseApiController;
use App\Modules\BaseApp\Enums\ResourceTypesEnums;
use App\Modules\Booking\Booking;
use App\Modules\Booking\Repository\BookingRepository;
use App\Modules\Booking\Requests\BookingRequest;
use App\Modules\Config\Config;
use App\Modules\Gallery\Repository\GalleryRepository;
use App\Modules\LandingPage\Transformers\{
    ConfigsTransformer,
    GalleryTransformer,
    TeamTransformer,
    WorkingHoursTransformer
};
use App\Modules\Team\Repository\TeamRepository;
use App\Modules\WorkingHours\ClinicClosingPeriod;
use App\Modules\WorkingHours\Repository\ClinicWorkingDayRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LandingPageController extends BaseApiController
{
    /**
     * 🧩 Get general configuration (for landing)
     */
    public function getConfig()
    {
        $configs = Config::all();
        return $this->transformDataModInclude($configs, '', new ConfigsTransformer(), ResourceTypesEnums::CONFIG);
    }

    /**
     * 🖼️ Get gallery items
     */
    public function gallery()
    {
        $galleries = (new GalleryRepository())->all();
        return $this->transformDataModInclude($galleries, '', new GalleryTransformer(), ResourceTypesEnums::GALLERY);
    }

    /**
     * 👨‍⚕️ Get team members
     */
    public function team()
    {
        $teamMembers = (new TeamRepository())->all();
        return $this->transformDataModInclude($teamMembers, '', new TeamTransformer(), ResourceTypesEnums::TEAM);
    }

    /**
     * 🗓️ Store a booking from the landing page
     */
    public function storeBooking(BookingRequest $request)
    {
        $bookingData = $request->getData()->toJsonApiArray()['attributes'];
        (new BookingRepository())->create($bookingData);

        return response()->json([
            "meta" => [
                'message' => trans('booking.booking Sent Successfully')
            ]
        ]);
    }

    /**
     * 🕓 Get working hours OR closed period message
     */
    public function workingHours()
    {
        $today = now()->toDateString();

        $closing = ClinicClosingPeriod::whereDate('from_date', '<=', $today)
            ->whereDate('to_date', '>=', $today)
            ->first();

        if ($closing) {
            return $this->transformDataModInclude(
                [],
                '',
                new WorkingHoursTransformer(),
                ResourceTypesEnums::WORKING_HOURS,
                [
                    'message' => "Clinic is closed from {$closing->from_date} to {$closing->to_date}" .
                        ($closing->reason ? " ({$closing->reason})" : ".")
                ]
            );
        }

        $repo = new ClinicWorkingDayRepository();
        $days = $repo->all()->where('is_active', 1)->map(function ($day) {
            $periods = [];

            if ($day->from_time && $day->to_time) {
                if ($day->break_from && $day->break_to) {
                    $periods[] = ['from' => $day->from_time, 'to' => $day->break_from];
                    $periods[] = ['from' => $day->break_to, 'to' => $day->to_time];
                } else {
                    $periods[] = ['from' => $day->from_time, 'to' => $day->to_time];
                }
            }

            return [
                'day' => $day->day,
                'periods' => $periods
            ];
        })->values();

        return $this->transformDataModInclude(
            $days,
            '',
            new WorkingHoursTransformer(),
            ResourceTypesEnums::WORKING_HOURS,
            ['message' => 'Clinic working hours retrieved successfully.']
        );
    }

    /**
     * 🧩 Get available slots for a specific date
     */
    public function availableSlotsForDay(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
        ]);

        $date = Carbon::parse($request->date);

        // check if date is within a closing period
        $closing = ClinicClosingPeriod::whereDate('from_date', '<=', $date)
            ->whereDate('to_date', '>=', $date)
            ->first();

        if ($closing) {
            return $this->transformDataModInclude(
                [],
                '',
                new WorkingHoursTransformer(),
                ResourceTypesEnums::WORKING_HOURS,
                [
                    'message' => "Clinic is closed from {$closing->from_date} to {$closing->to_date}" .
                        ($closing->reason ? " ({$closing->reason})" : ".")
                ]
            );
        }

        $dayName = $date->format('l');

        $repo = new ClinicWorkingDayRepository();
        $day = $repo->all()->where('day', $dayName)->where('is_active', 1)->first();

        if (!$day) {
            return $this->transformDataModInclude(
                [],
                '',
                new WorkingHoursTransformer(),
                ResourceTypesEnums::WORKING_HOURS,
                ['message' => 'Clinic closed on this day.']
            );
        }

        $slots = $repo->generateSlotsForDay($day);

        $bookedTimes = Booking::where('booking_date', $date->toDateString())
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('booking_time')
            ->map(fn($time) => Carbon::parse($time)->format('H:i'))
            ->toArray();

        $availableSlots = array_filter($slots, fn($slot) => !in_array($slot['from'], $bookedTimes));

        return $this->transformDataModInclude(
            array_values($availableSlots),
            '',
            new WorkingHoursTransformer(),
            ResourceTypesEnums::WORKING_HOURS,
            ['message' => 'Available slots retrieved successfully.']
        );
    }
}
