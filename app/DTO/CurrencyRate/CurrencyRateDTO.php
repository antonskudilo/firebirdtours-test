<?php

namespace App\DTO\CurrencyRate;

use InvalidArgumentException;

readonly class CurrencyRateDTO
{
    public function __construct(
        public string $currencyCode,
        public float $latestExchangeRate,
    ) {}

    /**
     * @param string $currencyCode
     * @param mixed $rate
     * @return CurrencyRateDTO
     */
    public static function fromItem(string $currencyCode, mixed $rate): self
    {
        if ($currencyCode === '') {
            throw new InvalidArgumentException('Currency code is empty');
        }

        if (!is_numeric($rate)) {
            throw new InvalidArgumentException(
                sprintf('Invalid exchange rate for currency %s', $currencyCode)
            );
        }

        return new self(
            currencyCode: $currencyCode,
            latestExchangeRate: (float) $rate,
        );
    }
}
