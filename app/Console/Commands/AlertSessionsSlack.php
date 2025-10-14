<?php

declare(strict_types = 1);

namespace App\Console\Commands;

use App\Modules\Courses\Models\SubModels\CourseSession;
use App\Modules\Users\UserEnums;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AlertSessionsSlack extends Command
{
     /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sessions:alert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Alert all sessions in next day';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sessions = CourseSession::where('date', Carbon::today())
        ->whereHas('course', function ($query) {
            $query->where('is_active', true)
                  ->whereHas('creator', function ($query) {
                      $query->where('type', UserEnums::SUPER_ADMIN_TYPE);
                  });
        })
        ->with(['course.creator'])
        ->get();
        foreach ($sessions as $session) {

            Log::channel('slack-alert')->info('session in ' . env("APP_NAME") ,[
                'admin name' => $session->course->creator->name,
                'action' => "session comming",
                'session' => $session,
            ]);

        }

        return 0;
    }
}