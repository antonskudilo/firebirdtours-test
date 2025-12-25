<?php

namespace App\Http\Clients\FreeCurrency;

use App\Enums\HttpMethods;
use App\Http\Clients\ApiRequest;

abstract class BaseFreeCurrencyRequest extends ApiRequest
{
    /**
     * @return string
     */
    public function url(): string
    {
        return rtrim(config('services.currency_api.url'), '/') .
            '/' . ltrim($this->endpoint(), '/');
    }

    /**
     * @return array
     */
    public function headers(): array
    {
        return [
            'apikey' => config('services.currency_api.key'),
            'Accept' => 'application/json',
        ];
    }

    /**
     * @return string
     */
    abstract protected function endpoint(): string;

    /**
     * @return HttpMethods
     */
    public function method(): HttpMethods
    {
        return HttpMethods::GET;
    }
}
