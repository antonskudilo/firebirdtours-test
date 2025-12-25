<?php

namespace App\Http\Controllers;

use App\Facades\CurrencyFacade;
use Illuminate\View\View;

class CurrencyRatesController extends Controller
{
    public function __construct(
        private readonly CurrencyFacade $facade
    ) {}

    /**
     * @return View
     */
    public function index(): View
    {
        return view('pages.currency_rates.index', [
            'rates' => $this->facade->listRates(),
        ]);
    }
}
