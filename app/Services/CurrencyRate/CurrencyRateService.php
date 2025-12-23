<?php

namespace App\Services\CurrencyRate;

use App\DTO\CurrencyRate\CurrencyPairRateDTO;
use App\DTO\CurrencyRate\CurrencyRateUpdateDTO;
use App\Entities\CurrencyRateEntity;
use App\Repositories\CurrencyRateRepository;
use Illuminate\Support\Facades\Log;
use Psr\SimpleCache\InvalidArgumentException;

readonly class CurrencyRateService
{
    public function __construct(
        private CurrencyRateRepository $repository,
        private CurrencyRateCache      $cache
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
     * @param string $from
     * @param string $to
     * @return CurrencyPairRateDTO
     */
    public function getCurrencyPairRateByCodes(string $from, string $to): CurrencyPairRateDTO
    {
        try {
            return $this->cache->rememberPair(
                $from,
                $to,
                fn () => $this->repository->getCurrencyPairRateByCodes($from, $to)
            );
        } catch (InvalidArgumentException $e) {
            Log::error('Currency rate cache error: ' . $e->getMessage());

            // In case of cache failure, fallback to direct repository call
            return $this->repository->getCurrencyPairRateByCodes($from, $to);
        }
    }
}
