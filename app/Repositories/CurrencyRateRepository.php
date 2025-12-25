<?php

namespace App\Repositories;

use App\DTO\CurrencyRate\CurrencyPairRateDTO;
use App\DTO\CurrencyRate\CurrencyRateUpdateDTO;
use App\Entities\CurrencyRateEntity;
use App\Exceptions\CurrencyRateNotFoundException;
use App\Models\CurrencyRate;
use Illuminate\Support\Facades\DB;

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
     * @param CurrencyRateUpdateDTO[] $items
     * @return void
     */
    public function batchUpdate(array $items): void
    {
        $now = now();
        $rows = [];

        foreach ($items as $item) {
            $rows[] = [
                'currency_id' => $item->currencyId,
                'latest_exchange_rate' => $item->latestExchangeRate,
                'updated_at' => $now,
            ];
        }

        DB::table('currency_rates')->upsert(
            $rows,
            ['currency_id'],
            ['latest_exchange_rate', 'updated_at']
        );
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
     * @param string $fromCode
     * @param string $toCode
     * @throws CurrencyRateNotFoundException
     * @return CurrencyPairRateDTO
     */
    public function getCurrencyPairRateByCodes(string $fromCode, string $toCode): CurrencyPairRateDTO
    {
        $rows = DB::table('currencies as c')
            ->join('currency_rates as r', 'r.currency_id', '=', 'c.id')
            ->whereIn('c.code', [$fromCode, $toCode])
            ->whereNull('c.deleted_at')
            ->select([
                'c.code',
                'r.latest_exchange_rate',
            ])
            ->get()
            ->keyBy('code');

        if (!$rows->has($fromCode)) {
            throw new CurrencyRateNotFoundException("Currency rate not found for '$fromCode'");
        }

        if (!$rows->has($toCode)) {
            throw new CurrencyRateNotFoundException("Currency rate not found for '$toCode'");
        }

        return new CurrencyPairRateDTO(
            fromCode: $fromCode,
            toCode: $toCode,
            fromRate: $rows[$fromCode]->latest_exchange_rate,
            toRate: $rows[$toCode]->latest_exchange_rate,
        );
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
