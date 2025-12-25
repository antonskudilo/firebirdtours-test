<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\CurrencyConvert\CurrencyConvertRequestDTO;
use App\Facades\CurrencyFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\CurrencyConvertRequest;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Post(
 *     path="/api/v1/convert",
 *     summary="Currency conversion",
 *     description="Converts an amount from one currency to another",
 *     tags={"Currency"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/CurrencyConvertRequestDTO")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful conversion",
 *         @OA\JsonContent(ref="#/components/schemas/CurrencyConvertResponseDTO")
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
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
 *                     @OA\Items(type="string", example="Source currency not found")
 *                 ),
 *                 @OA\Property(
 *                     property="to",
 *                     type="array",
 *                     @OA\Items(type="string", example="Target currency not found")
 *                 )
 *             )
 *         )
 *     )
 * )
 */
class CurrencyConvertController extends Controller
{
    public function __construct(
        private readonly CurrencyFacade $facade
    ) {}

    /**
     * @param CurrencyConvertRequest $request
     * @return JsonResponse
     */
    public function __invoke(CurrencyConvertRequest $request): JsonResponse
    {
        $responseDto = $this->facade->convert(
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
