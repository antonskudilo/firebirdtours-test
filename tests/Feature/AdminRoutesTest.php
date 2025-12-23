<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminRoutesTest extends TestCase
{
    use RefreshDatabase;

    protected function actingAsUser(): User
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        return $user;
    }

    public function testCurrenciesIndexAccessibleForAuthenticatedUser(): void
    {
        $this->actingAsUser();

        $response = $this->get(route('currencies.index'));
        $response->assertStatus(200);
        $response->assertViewIs('pages.currencies.index');
    }

    public function testCurrenciesCreatePageAccessible(): void
    {
        $this->actingAsUser();

        $response = $this->get(route('currencies.create'));
        $response->assertStatus(200);
        $response->assertViewIs('pages.currencies.create');
    }

    public function testCurrencyRatesIndexAccessible(): void
    {
        $this->actingAsUser();

        $response = $this->get(route('currency-rates.index'));
        $response->assertStatus(200);
        $response->assertViewIs('pages.currency_rates.index');
    }
}
