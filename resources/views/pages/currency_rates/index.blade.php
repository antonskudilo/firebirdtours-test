@php
    /** @var App\Entities\CurrencyRateEntity[] $rates */
@endphp

@extends('layouts.app')

@section('title', __('pages.currency_rates.index'))

@section('content')
    <table class="table table-striped">
        <tr>
            <th>@lang('pages/currency_rates.fields.code')</th>
            <th>@lang('pages/currency_rates.fields.name')</th>
            <th>@lang('pages/currency_rates.fields.rate')</th>
            <th>@lang('pages/currency_rates.fields.updated')</th>
        </tr>

        @foreach($rates as $rate)
            <tr>
                <td>{{ $rate->currencyCode }}</td>
                <td>{{ $rate->namePlural }}</td>
                <td>{{ $rate->latestExchangeRate }}</td>
                <td>{{ $rate->updatedAt }}</td>
            </tr>
        @endforeach
    </table>
@endsection
