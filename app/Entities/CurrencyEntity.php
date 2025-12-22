<?php

namespace App\Entities;

readonly class CurrencyEntity
{
    public function __construct(
        public int    $id,
        public string $code,
        public ?float $latest_exchange_rate,
        public string $namePlural,
    ) {}
}
