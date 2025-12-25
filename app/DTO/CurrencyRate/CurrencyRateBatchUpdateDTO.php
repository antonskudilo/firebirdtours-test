<?php

namespace App\DTO\CurrencyRate;

readonly class CurrencyRateBatchUpdateDTO
{
    /**
     * @param CurrencyRateUpdateDTO[] $items
     */
    public function __construct(
        public array $items
    ) {}
}
