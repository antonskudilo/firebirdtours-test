<?php

namespace App\Jobs;

use App\Services\CurrencyRate\CurrencyRateUpdaterService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class UpdateCurrencyRatesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 600;

    public function __construct(
        private readonly CurrencyRateUpdaterService $updaterService
    ) {}

    public function handle(): void
    {
        try {
            $this->updaterService->update();
        } catch (RuntimeException $e) {
            Log::error('UpdateCurrencyRatesJob failed', ['error' => $e->getMessage()]);

            throw $e;
        }

        Log::info('Currency rates updated successfully');
    }
}
