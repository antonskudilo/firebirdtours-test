<?php

namespace App\Facades;

use App\DTO\Currency\CurrencyDTO;
use App\DTO\CurrencyConvert\CurrencyConvertRequestDTO;
use App\DTO\CurrencyConvert\CurrencyConvertResponseDTO;
use App\Entities\CurrencyEntity;
use App\Entities\CurrencyRateEntity;
use App\Exceptions\CurrencyRateNotFoundException;
use App\Exceptions\EntityNotFoundException;
use App\Repositories\CurrencyRepository;
use App\Services\CurrencyConverterService;
use App\Services\CurrencyRate\CurrencyRateService;
use App\Services\CurrencyRate\CurrencyRateUpdaterService;
use RuntimeException;

readonly class CurrencyFacade
{
    public function __construct(
        private CurrencyRepository        $currencyRepository,
        private CurrencyRateService       $currencyRateService,
        private CurrencyConverterService  $currencyConverterService,
        private CurrencyRateUpdaterService $currencyRateUpdaterService
    ) {}

    // ===== CurrencyRepository methods (CRUD) =====
    /**
     * @return CurrencyEntity[]
     */
    public function listCurrencies(): array
    {
        return $this->currencyRepository->all();
    }

    /**
     * @param int $id
     * @return CurrencyEntity
     * @throws EntityNotFoundException
     */
    public function findCurrency(int $id): CurrencyEntity
    {
        return $this->currencyRepository->find($id);
    }

    /**
     * @param string $code
     * @return CurrencyEntity
     * @throws EntityNotFoundException
     */
    public function findCurrencyByCode(string $code): CurrencyEntity
    {
        return $this->currencyRepository->findByCode($code);
    }

    /**
     * @param CurrencyDTO $dto
     * @return CurrencyEntity
     */
    public function createCurrency(CurrencyDTO $dto): CurrencyEntity
    {
        return $this->currencyRepository->create($dto);
    }

    /**
     * @param int $id
     * @param CurrencyDTO $dto
     * @return CurrencyEntity
     * @throws EntityNotFoundException
     */
    public function updateCurrency(int $id, CurrencyDTO $dto): CurrencyEntity
    {
        return $this->currencyRepository->update($id, $dto);
    }

    /**
     * @param int $id
     * @return void
     * @throws EntityNotFoundException
     */
    public function deleteCurrency(int $id): void
    {
        $this->currencyRepository->delete($id);
    }

    // ===== CurrencyRateService methods =====
    /**
     * @return CurrencyRateEntity[]
     */
    public function listRates(): array
    {
        return $this->currencyRateService->list();
    }

    /**
     * @return void
     * @throws RuntimeException
     */
    public function refreshRates(): void
    {
        $this->currencyRateUpdaterService->update();
    }

    // ===== CurrencyConverterService methods =====
    /**
     * @param CurrencyConvertRequestDTO $dto
     * @param int $precision
     * @return CurrencyConvertResponseDTO
     * @throws CurrencyRateNotFoundException
     */
    public function convert(CurrencyConvertRequestDTO $dto, int $precision = 4): CurrencyConvertResponseDTO
    {
        return $this->currencyConverterService->convert($dto, $precision);
    }
}
