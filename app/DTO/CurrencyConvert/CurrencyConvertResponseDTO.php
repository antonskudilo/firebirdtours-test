<?php

namespace App\DTO\CurrencyConvert;

/**
 * @OA\Schema(
 *     schema="CurrencyConvertResponseDTO",
 *     type="object",
 *     @OA\Property(property="amount", type="number", format="float", example=100),
 *     @OA\Property(property="from", type="string", example="USD"),
 *     @OA\Property(property="to", type="string", example="EUR"),
 *     @OA\Property(property="result", type="number", format="float", example=85.50)
 * )
 */
readonly class CurrencyConvertResponseDTO
{
    public function __construct(
        public float  $amount,
        public string $from,
        public string $to,
        public float  $result
    ) {}
}
