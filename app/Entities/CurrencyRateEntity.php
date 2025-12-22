<?php

namespace App\Entities;

readonly class CurrencyRateEntity
{
    public function __construct(
        public int    $id,
        public int    $currencyId,
        public string $currencyCode,
        public string $namePlural,
        public float  $latestExchangeRate,
        public string $updatedAt,
    ) {}
}
