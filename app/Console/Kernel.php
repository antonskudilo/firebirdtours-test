<?php

namespace App\Console;

use App\Jobs\UpdateCurrencyRatesJob;
use App\Services\CurrencyRate\CurrencyRateUpdaterService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(new UpdateCurrencyRatesJob(
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
