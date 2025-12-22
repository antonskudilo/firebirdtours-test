<?php

namespace App\Services;

use App\DTO\CurrencyRate\CurrencyRateUpdateDTO;
use App\Entities\CurrencyRateEntity;
use App\Repositories\CurrencyRateRepository;

readonly class CurrencyRateService
{
    public function __construct(
        private CurrencyRateRepository $repository
    ) {}

    /**
     * @return CurrencyRateEntity[]
     */
    public function list(): array
    {
        return $this->repository->all();
    }

    /**
     * @param CurrencyRateUpdateDTO $dto
     * @return CurrencyRateEntity
     */
    public function update(CurrencyRateUpdateDTO $dto): CurrencyRateEntity
    {
        return $this->repository->update($dto);
    }
}
