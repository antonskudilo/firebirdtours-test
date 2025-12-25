<?php

namespace App\Services\CurrencyRate;

use App\DTO\CurrencyRate\CurrencyRateDTO;
use App\Http\Clients\ApiClient;
use App\Http\Clients\FreeCurrency\FreeCurrencyLatestRequest;
use RuntimeException;

readonly class FreeCurrencyRatesProvider implements CurrencyRatesProviderInterface
{
    public function __construct(
        private ApiClient $client
    ) {}

    /**
     * @throws RuntimeException
     * @return CurrencyRateDTO[]
     */
    public function getLatestRates(): array
    {
        $response = $this->client->send(
            new FreeCurrencyLatestRequest()
        );

        return $this->mapResponse($response);
    }

    /**
     * @param array $response
     * @return CurrencyRateDTO[]
     */
    private function mapResponse(array $response): array
    {
        $result = [];

        foreach ($response['data'] ?? [] as $code => $rate) {
            $result[] = new CurrencyRateDTO(
                currencyCode: $code,
                latestExchangeRate: (float)$rate
            );
        }

        return $result;
    }
}
