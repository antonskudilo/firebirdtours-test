<?php

namespace App\Services;

use App\DTO\CurrencyConvert\CurrencyConvertRequestDTO;
use App\DTO\CurrencyConvert\CurrencyConvertResponseDTO;
use App\Exceptions\CurrencyRateNotFoundException;
use App\Services\CurrencyRate\CurrencyRateService;

readonly class CurrencyConverterService
{
    public function __construct(
        private CurrencyRateService $currencyRateService,
    ) {}

    /**
     * @param CurrencyConvertRequestDTO $dto
     * @param int $precision
     * @return CurrencyConvertResponseDTO
     * @throws CurrencyRateNotFoundException
     */
    public function convert(CurrencyConvertRequestDTO $dto, int $precision = 4): CurrencyConvertResponseDTO
    {
        if ($dto->from === $dto->to) {
            return new CurrencyConvertResponseDTO(
                amount: $dto->amount,
                from: $dto->from,
                to: $dto->to,
                result: round($dto->amount, $precision)
            );
        }

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

