<?php

namespace App\Http\Clients\FreeCurrencyAPI;

class FreeCurrencyLatestRequest extends BaseFreeCurrencyAPI
{
    protected function endpoint(): string
    {
        return '/v1/latest';
    }
}
