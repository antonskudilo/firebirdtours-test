<?php

namespace App\Http\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use RuntimeException;

readonly class ApiClient
{
    protected const REQUEST_TIMEOUT = 10;

    public function __construct(
        private Client $client
    ) {}

    /**
     * @param ApiRequest $request
     * @throws RuntimeException
     * @return array
     */
    public function send(ApiRequest $request): array
    {
        try {
            $response = $this->client->request(
                $request->method()->value,
                $request->url(),
                [
                    'headers' => $request->headers(),
                    'query'   => $request->query(),
                    'json'    => $request->body(),
                    'timeout' => self::REQUEST_TIMEOUT,
                ]
            );
        } catch (GuzzleException $e) {
            throw new RuntimeException('HTTP request failed', previous: $e);
        }

        $data = json_decode((string)$response->getBody(), true);

        if (!is_array($data)) {
            throw new RuntimeException('Invalid HTTP response');
        }

        return $data;
    }
}
