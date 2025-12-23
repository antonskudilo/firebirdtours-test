<?php

namespace Tests\Feature;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuestAccessTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestCannotAccessCurrenciesPages(): void
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $pages = [
            route('currencies.index'),
            route('currencies.create'),
            route('currencies.show', 1),
            route('currencies.edit', 1),
        ];

        foreach ($pages as $page) {
            $response = $this->get($page);
            $response->assertRedirect(route('login.form'));
        }
    }

    public function testGuestCannotAccessCurrencyRatesPage(): void
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $response = $this->get(route('currency-rates.index'));
        $response->assertRedirect(route('login.form'));
    }
}
