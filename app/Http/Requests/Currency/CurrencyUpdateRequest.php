<?php

namespace App\Http\Requests\Currency;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyUpdateRequest extends FormRequest implements CurrencyRequestInterface
{
    public function rules(): array
    {
        return [
            'code' => [
                'required',
                'string',
                'max:8',
                'unique:currencies,code,' . $this->route('currency'),
            ],
            'name_plural' => ['required', 'string', 'max:32'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function getCode(): string
    {
        return $this->validated('code');
    }

    public function getNamePlural(): string
    {
        return $this->validated('name_plural');
    }
}

