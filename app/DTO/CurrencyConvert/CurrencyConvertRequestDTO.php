<?php

namespace App\DTO\CurrencyConvert;

use App\Http\Requests\CurrencyConvertRequest;

readonly class CurrencyConvertRequestDTO
{
    public function __construct(
        public float  $amount,
        public string $from,
        public string $to
    ) {}

    public static function fromRequest(CurrencyConvertRequest $request): static
    {
        return new static(
            amount: $request->validated('amount'),
            from: strtoupper($request->validated('from')),
            to: strtoupper($request->validated('to')),
        );
    }
}
