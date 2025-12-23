<?php

namespace App\Console\Commands;

use App\Jobs\UpdateCurrencyRatesJob;
use App\Services\Currency\CurrencyApiService;
use App\Services\CurrencyRate\CurrencyRateUpdaterService;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class UpdateCurrencyRatesCommand extends Command
{
    /**
     * Имя и сигнатура команды
     */
    protected $signature = 'currency:update-rates';

    /**
     * Описание команды
     */
    protected $description = 'Update currency rates from FreeCurrencyAPI';

    public function handle(): int
    {
        $this->info('Dispatching UpdateCurrencyRatesJob...');

        try {
            UpdateCurrencyRatesJob::dispatch(
                app(CurrencyApiService::class),
                app(CurrencyRateUpdaterService::class)
            );
        } catch (\Exception $e) {
            $this->error('Failed to dispatch UpdateCurrencyRatesJob: ' . $e->getMessage());

            return CommandAlias::SUCCESS;
        }

        $this->info('Job UpdateCurrencyRatesJob dispatched successfully');

        return CommandAlias::SUCCESS;
    }
}
