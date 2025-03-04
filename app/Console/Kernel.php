<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\SendBulkSms::class,
        \App\Console\Commands\DatabaseBackUp::class,
    ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('bulksms:send')->everyMinute();
        $schedule->command('smsModulSms:send')->everyMinute();
        $schedule->command('advanceSearchsms:send')->everyMinute();
        $schedule->command('jobsms:send')->everyMinute();
        $schedule->command('reset:otp_resend_count')->everyFiveMinutes();
        $schedule->command('tutor:deactive')->everyMinute();
        $schedule->command('database:backup')->weekly();

        $schedule->command('log:clear')->dailyAt('00:05');
        // $schedule->command('move:inactive-tutors')->everyMinute();
        // $schedule->command('move:active-tutors')->everyMinute();

    }



    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
