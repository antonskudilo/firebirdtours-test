<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\CurrencyConvert\CurrencyConvertRequestDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\CurrencyConvertRequest;
use App\Services\CurrencyConverterService;
use Illuminate\Http\JsonResponse;


/**
 * @OA\Post(
 *     path="/api/v1/convert",
 *     summary="Конвертация валют",
 *     description="Конвертирует сумму из одной валюты в другую",
 *     tags={"Currency"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/CurrencyConvertRequestDTO")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Успешная конвертация",
 *         @OA\JsonContent(ref="#/components/schemas/CurrencyConvertResponseDTO")
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Ошибка валидации",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="The given data was invalid."),
 *             @OA\Property(
 *                 property="errors",
 *                 type="object",
 *                 @OA\Property(
 *                     property="amount",
 *                     type="array",
 *                     @OA\Items(type="string", example="The amount must be at least 0.")
 *                 ),
 *                 @OA\Property(
 *                     property="from",
 *                     type="array",
 *                     @OA\Items(type="string", example="Исходная валюта не найдена")
 *                 ),
 *                 @OA\Property(
 *                     property="to",
 *                     type="array",
 *                     @OA\Items(type="string", example="Целевая валюта не найдена")
 *                 )
 *             )
 *         )
 *     )
 * )
 */
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
