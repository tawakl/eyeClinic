<?php

declare(strict_types = 1);

namespace App\Console;

use App\Modules\BaseApp\Jobs\CleanNotificationJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\App;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('sessions:alert')->dailyAt('00:00:00')->onOneServer();
        $schedule->command('validate:promo-codes-status')->dailyAt('00:00:00')->onOneServer();
        $schedule->command('execute:export-tasks')->everyMinute()->onOneServer();
        $schedule->command('vcrSession:notify-session-time')->everyFifteenMinutes()->onOneServer();
        $schedule->job(CleanNotificationJob::class)->dailyAt('00:00:00')->onOneServer();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
