<?php

namespace App\DTO\CurrencyRate;

readonly class CurrencyRateUpdateDTO
{
    public function __construct(
        public int   $currencyId,
        public float $latestExchangeRate
    ) {}
}
