<?php

namespace App\DTO\CurrencyRate;

readonly class CurrencyPairRateDTO
{
    public function __construct(
        public string $fromCode,
        public string $toCode,
        public string $fromRate,
        public string $toRate,
    ) {}
}
