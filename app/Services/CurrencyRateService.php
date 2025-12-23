<?php

namespace App\Services;

use App\DTO\CurrencyRate\CurrencyPairRateDTO;
use App\DTO\CurrencyRate\CurrencyRateUpdateDTO;
use App\Entities\CurrencyRateEntity;
use App\Exceptions\CurrencyRateNotFoundException;
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

    /**
     * @param string $fromCode
     * @param string $toCode
     * @throws CurrencyRateNotFoundException
     * @return CurrencyPairRateDTO
     */
    public function getCurrencyPairRateByCodes(string $fromCode, string $toCode): CurrencyPairRateDTO
    {
        return $this->repository->getCurrencyPairRateByCodes($fromCode, $toCode);
    }
}
