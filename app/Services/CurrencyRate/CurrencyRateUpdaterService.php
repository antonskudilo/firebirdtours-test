<?php

namespace App\Services\CurrencyRate;

use App\DTO\CurrencyRate\CurrencyRateBatchUpdateDTO;
use App\DTO\CurrencyRate\CurrencyRateUpdateDTO;
use App\Repositories\CurrencyRepository;
use RuntimeException;

readonly class CurrencyRateUpdaterService
{
    public function __construct(
        private CurrencyRepository             $currencyRepository,
        private CurrencyRatesProviderInterface $ratesProvider,
        private CurrencyRateService            $currencyRateService,
        private CurrencyRateCache              $cache
    ) {}

    /**
     * @throws RuntimeException
     */
    public function update(): void
    {
        $rates = $this->ratesProvider->getLatestRates();
        $existing = $this->getCurrencyIds();
        $batch = [];

        foreach ($rates as $rateDto) {
            if (!isset($existing[$rateDto->currencyCode])) {
                continue;
            }

            $batch[] = new CurrencyRateUpdateDTO(
                currencyId: $existing[$rateDto->currencyCode],
                latestExchangeRate: $rateDto->latestExchangeRate
            );
        }

        if ($batch !== []) {
            $this->currencyRateService->batchUpdate(
                new CurrencyRateBatchUpdateDTO($batch)
            );
        }

        $this->cache->flush();
    }

    /**
     * @return array
     */
    private function getCurrencyIds(): array
    {
        $currencies = $this->currencyRepository->all();
        $currencyIds = [];

        foreach ($currencies as $currency) {
            $currencyIds[$currency->code] = $currency->id;
        }

        return $currencyIds;
    }
}
