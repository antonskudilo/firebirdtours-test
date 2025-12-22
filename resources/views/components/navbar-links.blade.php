<a class="btn btn-outline-light btn-sm me-2 {{ request()->routeIs('currencies.index') ? 'active' : '' }}"
   href="{{ route('currencies.index') }}">
    Currencies
</a>

<a class="btn btn-outline-light btn-sm {{ request()->routeIs('currency-rates.index') ? 'active' : '' }}"
   href="{{ route('currency-rates.index') }}">
    Currency Rates
</a>
