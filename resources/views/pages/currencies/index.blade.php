@php
    /** @var App\Entities\CurrencyEntity[] $currencies */
@endphp

@extends('layouts.app')

@section('title', __('pages.currencies.index'))

@section('content')
    <table class="table table-bordered">
        <tr>
            <th>@lang('pages/currencies.fields.id')</th>
            <th>@lang('pages/currencies.fields.code')</th>
            <th>@lang('pages/currencies.fields.name')</th>
            <th></th>
        </tr>

        @foreach($currencies as $currency)
            <tr>
                <td>{{ $currency->id }}</td>
                <td>{{ $currency->code }}</td>
                <td>{{ $currency->namePlural }}</td>

                <td>
                    <a href="{{ route('currencies.edit', $currency->id) }}" class="btn btn-sm btn-primary">
                        @lang('actions.edit')
                    </a>

                    <form method="POST" action="{{ route('currencies.destroy', $currency->id) }}" class="d-inline">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-sm btn-danger">@lang('actions.delete')</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
