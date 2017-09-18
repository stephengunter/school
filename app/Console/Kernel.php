<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\SyncUsers::class,
        Commands\SyncDepartments::class,
        Commands\SyncEvents::class,
        Commands\SyncNotices::class,
        Commands\SyncGroups::class,
        Commands\SyncClasses::class,
        Commands\SyncUnits::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('sync:events')->everyFiveMinutes();
        $schedule->command('sync:notices')->everyFiveMinutes();
        
        $schedule->command('sync:classes')->dailyAt('00:00');
        $schedule->command('sync:units')->dailyAt('00:30');
        $schedule->command('sync:departments')->dailyAt('01:00');
        $schedule->command('sync:users')->dailyAt('02:00');
        $schedule->command('sync:group')->dailyAt('05:00');
        
             
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
