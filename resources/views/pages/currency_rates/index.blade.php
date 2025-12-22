@php
    /** @var App\Entities\CurrencyRateEntity[] $rates */
@endphp

@extends('layouts.app')

@section('title', 'Курсы валют')

@section('content')
    <table class="table table-striped">
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Rate (USD)</th>
            <th>Updated</th>
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
