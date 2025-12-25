<?php

namespace App\Services\CurrencyRate;

use App\DTO\CurrencyRate\CurrencyRateDTO;

interface CurrencyRatesProviderInterface
{
    /**
     * @return CurrencyRateDTO[]
     */
    public function getLatestRates(): array;
}
