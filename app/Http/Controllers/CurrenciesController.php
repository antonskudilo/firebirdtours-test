<?php

namespace App\Http\Controllers;

use App\DTO\Currency\CurrencyDTO;
use App\Facades\CurrencyFacade;
use App\Http\Requests\Currency\CurrencyStoreRequest;
use App\Http\Requests\Currency\CurrencyUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CurrenciesController extends Controller
{
    public function __construct(
        private readonly CurrencyFacade $facade
    ) {}

    /**
     * @return View
     */
    public function index(): View
    {
        return view('pages.currencies.index', [
            'currencies' => $this->facade->listCurrencies(),
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('pages.currencies.create');
    }

    /**
     * @param CurrencyStoreRequest $request
     * @return RedirectResponse
     */
    public function store(CurrencyStoreRequest $request): RedirectResponse
    {
        $currency = $this->facade->createCurrency(
            CurrencyDTO::fromRequest($request)
        );

        return redirect()
            ->route('currencies.index')
            ->with('success', "Валюта $currency->code создана");
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        return view('pages.currencies.edit', [
            'currency' => $this->facade->findCurrency($id),
        ]);
    }

    /**
     * @param CurrencyUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(CurrencyUpdateRequest $request, int $id): RedirectResponse
    {
        $this->facade->updateCurrency($id, CurrencyDTO::fromRequest($request));

        return redirect()
            ->route('currencies.index')
            ->with('success', 'Валюта обновлена');
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->facade->deleteCurrency($id);

        return redirect()
            ->route('currencies.index')
            ->with('success', 'Валюта удалена');
    }
}
