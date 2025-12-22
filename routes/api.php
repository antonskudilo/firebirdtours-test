<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CurrencyConvertController;

Route::prefix('v1')->group(function () {
    Route::post('/convert', CurrencyConvertController::class);
});
