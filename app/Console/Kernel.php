<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\SeeStatusPendingTask::class,
        \App\Console\Commands\DownloadVehicles::class,
        \App\Console\Commands\EntriesVehicles::class,
        \App\Console\Commands\StockVehicles::class,
        \App\Console\Commands\DeliveryVehicles::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('status:pendingtask')->everyMinute();
        $schedule->command('download:vehicles')->everyMinute();
        $schedule->command('stock:vehicles')->dailyAt('08:30');
        $schedule->command('entry:vehicles')->dailyAt('08:30');
        $schedule->command('delivery:vehicles')->dailyAt('08:30');
        $schedule->command('entry:vehicles')->dailyAt('13:30');
        $schedule->command('stock:vehicles')->dailyAt('13:30');
        $schedule->command('delivery:vehicles')->dailyAt('13:30');
    }


}
