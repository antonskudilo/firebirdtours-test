<?php

namespace App\Services\Currency;

use App\DTO\CurrencyRate\CurrencyRateDTO;
use App\Http\Clients\FreeCurrencyAPI\FreeCurrencyLatestRequest;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

class CurrencyApiService
{
    /**
     * @return CurrencyRateDTO[]
     * @throws RuntimeException
     */
    public function getLatestRates(): array
    {
        $response = (new FreeCurrencyLatestRequest())->send();

        if (!isset($response['data']) || !is_array($response['data'])) {
            Log::error('FreeCurrencyAPI: invalid response structure', [
                'response' => $response,
            ]);

            throw new RuntimeException('Invalid response from currency API');
        }

        $dtos = [];

        foreach ($response['data'] as $currencyCode => $rate) {
            try {
                $dtos[] = CurrencyRateDTO::fromItem(
                    (string)$currencyCode,
                    $rate
                );
            } catch (Throwable $e) {
                Log::error('Failed to create CurrencyRateDTO', [
                    'currency' => $currencyCode,
                    'rate'     => $rate,
                    'error'    => $e->getMessage(),
                ]);

                throw new RuntimeException('Failed to map currency rate DTO', previous: $e);
            }
        }

        return $dtos;
    }
}
