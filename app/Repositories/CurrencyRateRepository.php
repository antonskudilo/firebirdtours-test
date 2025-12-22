<?php

namespace App\Repositories;

use App\DTO\CurrencyRate\CurrencyRateUpdateDTO;
use App\Entities\CurrencyRateEntity;
use App\Models\CurrencyRate;

/**
 * @return CurrencyRateEntity[]
 */
class CurrencyRateRepository
{
    /**
     * @return CurrencyRateEntity[]
     */
    public function all(): array
    {
        return CurrencyRate::query()
            ->join('currencies', 'currencies.id', '=', 'currency_rates.currency_id')
            ->whereNull('currencies.deleted_at')
            ->orderBy('currencies.name_plural')
            ->select(['currency_rates.*', 'currencies.code', 'currencies.name_plural'])
            ->get()
            ->map(fn (CurrencyRate $rate) => $this->toEntity($rate))
            ->all();
    }

    /**
     * @param CurrencyRateUpdateDTO $dto
     * @return CurrencyRateEntity
     */
    public function update(CurrencyRateUpdateDTO $dto): CurrencyRateEntity
    {
        $currencyRate = CurrencyRate::query()->updateOrCreate(
            ['currency_id' => $dto->currencyId],
            ['latest_exchange_rate' => $dto->latestExchangeRate]
        );

        return $this->toEntity($currencyRate);
    }

    /**
     * @param CurrencyRate $currencyRate
     * @return CurrencyRateEntity
     */
    private function toEntity(CurrencyRate $currencyRate): CurrencyRateEntity
    {
        return new CurrencyRateEntity(
            id: $currencyRate->id,
            currencyId: $currencyRate->currency_id,
            currencyCode: $currencyRate->currency->code,
            namePlural: $currencyRate->currency->name_plural,
            latestExchangeRate: (float)$currencyRate->latest_exchange_rate,
            updatedAt: $currencyRate->updated_at->toDateTimeString(),
        );
    }
}
