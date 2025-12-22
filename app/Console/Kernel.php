<?php

namespace App\Console;

use App\Jobs\UpdateCurrencyRatesJob;
use App\Services\CurrencyApiService;
use App\Services\CurrencyRateUpdaterService;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Console\Scheduling\Schedule;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(new UpdateCurrencyRatesJob(
            app(CurrencyApiService::class),
            app(CurrencyRateUpdaterService::class)
        ))
            ->dailyAt('0:00')
            ->onOneServer()
            ->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }
}
