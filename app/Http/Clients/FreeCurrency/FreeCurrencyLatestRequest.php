<?php

namespace App\Http\Clients\FreeCurrency;

class FreeCurrencyLatestRequest extends BaseFreeCurrencyRequest
{
    protected function endpoint(): string
    {
        return '/v1/latest';
    }

    public function query(): array
    {
        return [];
    }
}
