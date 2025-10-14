<?php

declare(strict_types = 1);

namespace App\Console\Commands;

use App\Modules\BaseNotification\Jobs\FinishVCRSessionJob;
use App\Modules\BaseNotification\Jobs\NotificationStudentsJob;
use App\Modules\Courses\Enums\CourseSessionEnums;
use App\Modules\Courses\Repository\CourseRepository;
use App\Modules\Notifications\Models\TrackedVCRNotification;
use App\Modules\Users\User;
use App\Modules\Users\UserEnums;
use App\Modules\VCRSessions\Models\VCRSession;
use App\Modules\VCRSessions\UseCases\VCRSessionUseCase;
use Carbon\Carbon;
use Illuminate\Console\Command;

class NotifyVCRSessionsTimeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vcrSession:notify-session-time';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'vcrSession:notify-session-time';

    /**
     * Create a new command instance.
     * @return void
     */
    public function handle()
    {
        $now = now()->subMinute()->toDateTimeString();
        $time = now()->addMinutes(29)->toDateTimeString();
        $wheres = [
            ['time_to_start', '>=', $now],
            ['time_to_start', '<=', $time],
        ];

        // courses vcr sessions
        $coursesVCRSessions = VCRSession::query()
            ->where($wheres)
            ->whereHas('instructor')
            ->whereHas(
                "courseSession",
                function ($query) {
                    $query->where("status", "!=", CourseSessionEnums::CANCELED);
                    $query->whereHas(
                        "course",
                        function ($quer) {
                            $quer->where("is_active", "=", 1);
                        }
                    );
                }
            )
            ->where('is_notified', 0)
            ->get();
        if (!$coursesVCRSessions->isEmpty()) {
            foreach ($coursesVCRSessions as $vcrSession) {
                (new VCRSessionUseCase())->notifyVCRSession($vcrSession);
            }
        }
        return 0;
    }
}
