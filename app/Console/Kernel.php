<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('get:newsApi')->hourly();
        $schedule->command('get:nyTimesNewsApi')->hourly();
        $schedule->command('get:worldNewsApi')->hourly();
        $schedule->command('start:rabbitMqPublisherAndConsumer')->hourly();
        // $schedule->command('inspire')->hourly();
        // Add your scheduled tasks here.
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
