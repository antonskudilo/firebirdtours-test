<?php

namespace App\DTO\CurrencyConvert;

readonly class CurrencyConvertResponseDTO
{
    public function __construct(
        public float  $amount,
        public string $from,
        public string $to,
        public float  $result
    ) {}
}
