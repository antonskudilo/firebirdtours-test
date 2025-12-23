<?php

namespace App\DTO\Currency;

use App\Http\Requests\Currency\CurrencyRequestInterface;

readonly class CurrencyDTO
{
    private function __construct(
        public string $code,
        public string $namePlural,
    ) {}

    /**
     * @param CurrencyRequestInterface $request
     * @return static
     */
    public static function fromRequest(CurrencyRequestInterface $request): static
    {
        return new static(
            code: strtoupper($request->getCode()),
            namePlural: $request->getNamePlural(),
        );
    }
}
