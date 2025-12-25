<?php

namespace App\Providers;

use App\Services\CurrencyRate\CurrencyRatesProviderInterface;
use App\Services\CurrencyRate\FreeCurrencyRatesProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CurrencyRatesProviderInterface::class, FreeCurrencyRatesProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
