<?php

namespace App\Services;

use App\DTO\CurrencyConvert\CurrencyConvertRequestDTO;
use App\DTO\CurrencyConvert\CurrencyConvertResponseDTO;
use App\Exceptions\CurrencyRateNotFoundException;

readonly class CurrencyConverterService
{
    public function __construct(
        private CurrencyRateService $currencyRateService,
    ) {}

    /**
     * @param CurrencyConvertRequestDTO $dto
     * @param int $precision
     * @throws CurrencyRateNotFoundException
     * @return CurrencyConvertResponseDTO
     */
    public function convert(CurrencyConvertRequestDTO $dto, int $precision = 4): CurrencyConvertResponseDTO
    {
        $currencyPairRate = $this->currencyRateService->getCurrencyPairRateByCodes($dto->from, $dto->to);
        $amountInUsd = $dto->amount / $currencyPairRate->fromRate;
        $result = round($amountInUsd * $currencyPairRate->toRate, $precision);

        return new CurrencyConvertResponseDTO(
            amount: $dto->amount,
            from: $dto->from,
            to: $dto->to,
            result: $result
        );
    }
}

