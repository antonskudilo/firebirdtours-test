<?php

namespace App\Services;

use App\DTO\CurrencyConvert\CurrencyConvertRequestDTO;
use App\DTO\CurrencyConvert\CurrencyConvertResponseDTO;
use App\Exceptions\CurrencyRateNotFoundException;

readonly class CurrencyConverterService
{
    public function __construct(
        private CurrencyService $currencyService,
    ) {}

    /**
     * @param CurrencyConvertRequestDTO $dto
     * @param int $precision
     * @return CurrencyConvertResponseDTO
     */
    public function convert(CurrencyConvertRequestDTO $dto, int $precision = 4): CurrencyConvertResponseDTO
    {
        $fromRate = $this->currencyService->findByCode($dto->from)->latest_exchange_rate;
        $toRate = $this->currencyService->findByCode($dto->to)->latest_exchange_rate;

        if (!isset($fromRate)) {
            throw new CurrencyRateNotFoundException("Currency rate not found for '$dto->from'");
        }

        if (!isset($toRate)) {
            throw new CurrencyRateNotFoundException("Currency rate not found for '$dto->to'");
        }

        $amountInUsd = $dto->amount / $fromRate;
        $result = round($amountInUsd * $toRate, $precision);

        return new CurrencyConvertResponseDTO(
            amount: $dto->amount,
            from: $dto->from,
            to: $dto->to,
            result: $result
        );
    }
}

