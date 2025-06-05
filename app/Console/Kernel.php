<?php

namespace App\Console;

use App\Console\Commands\UpdateAttendanceCommand;
use App\Console\Commands\UpdateDataCommand;
use App\Console\Commands\UpdateLeaveCommand;
use App\Events\UpdateLastSeen;
use App\Events\UserLoggedOut;
use App\Mail\WelcomeEmail;
use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        UpdateDataCommand::class,
        UpdateAttendanceCommand::class,
        UpdateLeaveCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//        $schedule->command(UpdateDataCommand::class);
//        $schedule->command(UpdateAttendanceCommand::class);
//        $schedule->command(UpdateLeaveCommand::class);
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
