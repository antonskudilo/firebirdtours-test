<?php

namespace App\Http\Controllers;

use App\DTO\Currency\CurrencyDTO;
use App\Http\Requests\Currency\CurrencyStoreRequest;
use App\Http\Requests\Currency\CurrencyUpdateRequest;
use App\Repositories\CurrencyRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CurrenciesController extends Controller
{
    public function __construct(
        private readonly CurrencyRepository $repository
    ) {}

    /**
     * @return View
     */
    public function index(): View
    {
        return view('pages.currencies.index', [
            'currencies' => $this->repository->all(),
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
        $currency = $this->repository->create(
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
            'currency' => $this->repository->find($id),
        ]);
    }

    /**
     * @param CurrencyUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(CurrencyUpdateRequest $request, int $id): RedirectResponse
    {
        $this->repository->update($id, CurrencyDTO::fromRequest($request));

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
        $this->repository->delete($id);

        return redirect()
            ->route('currencies.index')
            ->with('success', 'Валюта удалена');
    }
}
