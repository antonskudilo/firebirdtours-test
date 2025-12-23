<?php

namespace App\Services\CurrencyRate;

use App\DTO\CurrencyRate\CurrencyRateDTO;
use App\DTO\CurrencyRate\CurrencyRateUpdateDTO;
use App\Services\Currency\CurrencyService;
use RuntimeException;

readonly class CurrencyRateUpdaterService
{
    public function __construct(
        private CurrencyService     $currencyService,
        private CurrencyRateService $currencyRateService,
        private CurrencyRateCache   $cache
    ) {}

    /**
     * @param CurrencyRateDTO[] $rates
     * @throws RuntimeException
     */
    public function update(array $rates): void
    {
        $currencyIds = $this->getCurrencyIds();

        foreach ($rates as $rateDto) {
            if (!isset($currencyIds[$rateDto->currencyCode])) {
                continue;
            }

            $this->updateCurrencyRate(
                currencyId: $currencyIds[$rateDto->currencyCode],
                latestExchangeRate: $rateDto->latestExchangeRate
            );
        }

        $this->cache->flush();
    }

    /**
     * @return array
     */
    private function getCurrencyIds(): array
    {
        $currencies = $this->currencyService->list();
        $currencyIds = [];

        foreach ($currencies as $currency) {
            $currencyIds[$currency->code] = $currency->id;
        }

        return $currencyIds;
    }

    /**
     * @param int $currencyId
     * @param float $latestExchangeRate
     * @return void
     */
    private function updateCurrencyRate(int $currencyId, float $latestExchangeRate): void
    {
        $currencyRateUpdateDTO = new CurrencyRateUpdateDTO(
            currencyId: $currencyId,
            latestExchangeRate: $latestExchangeRate
        );

        $this->currencyRateService->update($currencyRateUpdateDTO);
    }
}
