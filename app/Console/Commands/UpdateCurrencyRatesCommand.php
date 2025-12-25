<?php

namespace App\Console\Commands;

use App\Facades\CurrencyFacade;
use App\Jobs\UpdateCurrencyRatesJob;
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
                app(CurrencyFacade::class)
            );
        } catch (\Exception $e) {
            $this->error('Failed to dispatch UpdateCurrencyRatesJob: ' . $e->getMessage());

            return CommandAlias::SUCCESS;
        }

        $this->info('Job UpdateCurrencyRatesJob dispatched successfully');

        return CommandAlias::SUCCESS;
    }
}
