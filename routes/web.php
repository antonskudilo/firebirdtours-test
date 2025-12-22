<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CurrenciesController;
use App\Http\Controllers\CurrencyRatesController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::resource('currencies', CurrenciesController::class);
    Route::get('currency-rates', [CurrencyRatesController::class, 'index'])
        ->name('currency-rates.index');
});

Route::get("{any?}", function () {
    return redirect()->route('currencies.index');
});

