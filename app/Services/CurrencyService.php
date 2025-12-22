<?php

namespace App\Services;

use App\DTO\Currency\CurrencyDTO;
use App\Entities\CurrencyEntity;
use App\Exceptions\EntityNotFoundException;
use App\Repositories\CurrencyRepository;

/**
 * @return CurrencyEntity[]
 */
readonly class CurrencyService
{
    public function __construct(
        private CurrencyRepository $repository
    ) {}

    /**
     * @param int $id
     * @throws EntityNotFoundException
     * @return CurrencyEntity
     */
    public function find(int $id): CurrencyEntity
    {
        return $this->repository->find($id);
    }

    /**
     * @param string $code
     * @return CurrencyEntity
     */
    public function findByCode(string $code): CurrencyEntity
    {
        return $this->repository->findByCode($code);
    }

    /**
     * @return CurrencyEntity[]
     */
    public function list(): array
    {
        return $this->repository->all();
    }

    /**
     * @param CurrencyDTO $dto
     * @return CurrencyEntity
     */
    public function create(CurrencyDTO $dto): CurrencyEntity
    {
        return $this->repository->create($dto);
    }

    /**
     * @param int $id
     * @param CurrencyDTO $dto
     * @throws EntityNotFoundException
     * @return CurrencyEntity
     */
    public function update(int $id, CurrencyDTO $dto): CurrencyEntity
    {
        return $this->repository->update($id, $dto);
    }

    /**
     * @param int $id
     * @throws EntityNotFoundException
     * @return void
     */
    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
}
