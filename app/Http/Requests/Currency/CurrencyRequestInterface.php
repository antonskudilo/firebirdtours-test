<?php

namespace App\Http\Requests\Currency;

interface CurrencyRequestInterface
{
    public function getCode(): string;
    public function getNamePlural(): string;
}
