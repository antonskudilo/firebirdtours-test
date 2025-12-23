<?php

namespace App\DTO\CurrencyConvert;

use App\Http\Requests\CurrencyConvertRequest;

/**
 * @OA\Schema(
 *     schema="CurrencyConvertRequestDTO",
 *     type="object",
 *     required={"amount","from","to"},
 *     @OA\Property(property="amount", type="number", format="float", example=100, description="Сумма для конвертации"),
 *     @OA\Property(property="from", type="string", example="USD", description="Код исходной валюты"),
 *     @OA\Property(property="to", type="string", example="EUR", description="Код целевой валюты")
 * )
 */
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
