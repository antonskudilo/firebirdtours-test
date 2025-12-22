<?php

namespace App\Http\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use RuntimeException;

abstract class BaseApiRequest
{
    protected const DEFAULT_TIMEOUT = 10;

    protected Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->baseUri(),
            'timeout'  => static::DEFAULT_TIMEOUT,
        ]);
    }

    /**
     * Базовый URL API
     */
    abstract protected function baseUri(): string;

    /**
     * HTTP headers
     */
    abstract protected function headers(): array;

    /**
     * Endpoint URI
     */
    abstract protected function endpoint(): string;

    /**
     * Query параметры
     */
    abstract protected function query(): array;

    /**
     * Выполнение запроса
     */
    public function send(): array
    {
        try {
            $response = $this->client->get($this->endpoint(), [
                'headers' => $this->headers(),
                'query'   => $this->query(),
            ]);
        } catch (GuzzleException $e) {
            throw new RuntimeException(
                'HTTP request failed',
                previous: $e
            );
        }

        $data = json_decode(
            $response->getBody()->getContents(),
            true
        );

        if (!is_array($data)) {
            throw new RuntimeException('Invalid HTTP response');
        }

        return $data;
    }
}
