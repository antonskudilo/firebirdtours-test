<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyConvertRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:0'],
            'from' => ['required', 'string', 'exists:currencies,code'],
            'to' => ['required', 'string', 'exists:currencies,code'],
        ];
    }

    public function messages(): array
    {
        return [
            'from.exists' => 'Исходная валюта не найдена',
            'to.exists' => 'Целевая валюта не найдена',
        ];
    }
}
