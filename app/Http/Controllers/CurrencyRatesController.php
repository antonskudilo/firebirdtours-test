<?php

namespace App\Http\Controllers;

use App\Services\CurrencyRateService;
use Illuminate\View\View;

class CurrencyRatesController extends Controller
{
    public function __construct(
        private readonly CurrencyRateService $service
    ) {}

    /**
     * @return View
     */
    public function index(): View
    {
        return view('pages.currency_rates.index', [
            'rates' => $this->service->list(),
        ]);
    }
}
