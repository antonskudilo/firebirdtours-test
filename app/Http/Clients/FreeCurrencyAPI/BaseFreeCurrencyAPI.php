<?php

namespace App\Http\Clients\FreeCurrencyAPI;
use App\Http\Clients\BaseApiRequest;

abstract class BaseFreeCurrencyAPI extends BaseApiRequest
{
    protected function baseUri(): string
    {
        return config('services.currency_api.url');
    }

    protected function headers(): array
    {
        return [
            'apikey' => config('services.currency_api.key'),
            'Accept' => 'application/json',
        ];
    }

    protected function query(): array
    {
        return [];
    }
}

