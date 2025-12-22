<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\CurrencyConvert\CurrencyConvertRequestDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\CurrencyConvertRequest;
use App\Services\CurrencyConverterService;
use Illuminate\Http\JsonResponse;

class CurrencyConvertController extends Controller
{
    public function __construct(
        private readonly CurrencyConverterService $converter
    ) {}

    /**
     * @param CurrencyConvertRequest $request
     * @return JsonResponse
     */
    public function __invoke(CurrencyConvertRequest $request): JsonResponse
    {
        $responseDto = $this->converter->convert(
            CurrencyConvertRequestDTO::fromRequest($request)
        );

        return response()->json([
            'amount' => $responseDto->amount,
            'from' => $responseDto->from,
            'to' => $responseDto->to,
            'result' => $responseDto->result,
        ]);
    }
}
