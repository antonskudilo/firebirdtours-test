<?php

namespace App\Http\Controllers;

use App\DTO\Currency\CurrencyDTO;
use App\Http\Requests\Currency\CurrencyStoreRequest;
use App\Http\Requests\Currency\CurrencyUpdateRequest;
use App\Services\Currency\CurrencyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CurrenciesController extends Controller
{
    public function __construct(
        private readonly CurrencyService $service
    ) {}

    /**
     * @return View
     */
    public function index(): View
    {
        return view('pages.currencies.index', [
            'currencies' => $this->service->list(),
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
        $currency = $this->service->create(
            CurrencyDTO::fromRequest($request)
        );

        return redirect()
            ->route('currencies.index')
            ->with('success', "Валюта {$currency->code} создана");
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        return view('pages.currencies.edit', [
            'currency' => $this->service->find($id),
        ]);
    }

    /**
     * @param CurrencyUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(CurrencyUpdateRequest $request, int $id): RedirectResponse
    {
        $this->service->update($id, CurrencyDTO::fromRequest($request));

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
        $this->service->delete($id);

        return redirect()
            ->route('currencies.index')
            ->with('success', 'Валюта удалена');
    }
}
