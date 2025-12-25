<?php

namespace App\Repositories;

use App\DTO\Currency\CurrencyDTO;
use App\Entities\CurrencyEntity;
use App\Exceptions\EntityNotFoundException;
use App\Models\Currency;

/**
 * @return CurrencyEntity[]
 */
class CurrencyRepository
{
    /**
     * @param int $id
     * @return CurrencyEntity
     * @throws EntityNotFoundException
     */
    public function find(int $id): CurrencyEntity
    {
        $currency = Currency::query()
            ->with('rate')
            ->find($id);

        if (!isset($currency)) {
            throw new EntityNotFoundException("Currency {$id} not found");
        }

        return $this->toEntity($currency);
    }

    /**
     * @param string $code
     * @throws EntityNotFoundException
     * @return CurrencyEntity
     */
    public function findByCode(string $code): CurrencyEntity
    {
        $currency = Currency::query()
            ->with('rate')
            ->byCode($code)
            ->first();

        if (!isset($currency)) {
            throw new EntityNotFoundException("Currency {$code} not found");
        }

        return $this->toEntity($currency);
    }

    /**
     * @return CurrencyEntity[]
     */
    public function all(): array
    {
        return Currency::query()
            ->orderBy('name_plural')
            ->get()
            ->map(fn (Currency $currency) => $this->toEntity($currency))
            ->all();
    }

    /**
     * @param CurrencyDTO $dto
     * @return CurrencyEntity
     */
    public function create(CurrencyDTO $dto): CurrencyEntity
    {
        $currency = Currency::query()->create([
            'code' => $dto->code,
            'name_plural' => $dto->namePlural,
        ]);

        return $this->toEntity($currency);
    }

    /**
     * @param int $id
     * @param CurrencyDTO $dto
     * @throws EntityNotFoundException
     * @return CurrencyEntity
     */
    public function update(int $id, CurrencyDTO $dto): CurrencyEntity
    {
        $currency = Currency::query()->find($id);

        if (!$currency) {
            throw new EntityNotFoundException("Currency {$id} not found");
        }

        $currency->update([
            'code' => $dto->code,
            'name_plural' => $dto->namePlural,
        ]);

        return $this->toEntity($currency);
    }

    /**
     * @param int $id
     * @throws EntityNotFoundException
     * @return void
     */
    public function delete(int $id): void
    {
        $currency = Currency::query()->find($id);

        if (!$currency) {
            throw new EntityNotFoundException("Currency {$id} not found");
        }

        $currency->delete(); // soft delete
    }

    /**
     * @param Currency $currency
     * @return CurrencyEntity
     */
    private function toEntity(Currency $currency): CurrencyEntity
    {
        return new CurrencyEntity(
            id: $currency->id,
            code: $currency->code,
            latest_exchange_rate: $currency->rate?->latest_exchange_rate,
            namePlural: $currency->name_plural,
        );
    }
}
