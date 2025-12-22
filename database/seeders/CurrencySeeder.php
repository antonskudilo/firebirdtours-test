<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Currency;

class CurrencySeeder extends Seeder
{
    public function run(): void
    {
        $currencies = [
            'EUR' => 'Euro',
            'USD' => 'US Dollar',
            'JPY' => 'Japanese Yen',
            'BGN' => 'Bulgarian Lev',
            'CZK' => 'Czech Republic Koruna',
            'DKK' => 'Danish Krone',
            'GBP' => 'British Pound Sterling',
            'HUF' => 'Hungarian Forint',
            'PLN' => 'Polish Zloty',
            'RON' => 'Romanian Leu',
            'SEK' => 'Swedish Krona',
            'CHF' => 'Swiss Franc',
            'ISK' => 'Icelandic Króna',
            'NOK' => 'Norwegian Krone',
            'HRK' => 'Croatian Kuna',
            'RUB' => 'Russian Ruble',
            'TRY' => 'Turkish Lira',
            'AUD' => 'Australian Dollar',
            'BRL' => 'Brazilian Real',
            'CAD' => 'Canadian Dollar',
            'CNY' => 'Chinese Yuan',
            'HKD' => 'Hong Kong Dollar',
            'IDR' => 'Indonesian Rupiah',
            'ILS' => 'Israeli New Sheqel',
            'INR' => 'Indian Rupee',
            'KRW' => 'South Korean Won',
            'MXN' => 'Mexican Peso',
            'MYR' => 'Malaysian Ringgit',
            'NZD' => 'New Zealand Dollar',
            'PHP' => 'Philippine Peso',
            'SGD' => 'Singapore Dollar',
            'THB' => 'Thai Baht',
            'ZAR' => 'South African Rand',
        ];

        foreach ($currencies as $code => $name) {
            Currency::upsert(
                [
                    [
                        'code' => $code,
                        'name_plural' => $name,
                    ],
                ],
                ['code'],
                ['name_plural']
            );
        }
    }
}
