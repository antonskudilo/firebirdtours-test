@php
    /** @var App\Entities\CurrencyEntity[] $currencies */
@endphp

@extends('layouts.app')

@section('title', 'Валюты')

@section('content')
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Code</th>
            <th>Name</th>
            <th></th>
        </tr>

        @foreach($currencies as $currency)
            <tr>
                <td>{{ $currency->id }}</td>
                <td>{{ $currency->code }}</td>
                <td>{{ $currency->namePlural }}</td>

                <td>
                    <a href="{{ route('currencies.edit', $currency->id) }}" class="btn btn-sm btn-primary">Edit</a>

                    <form method="POST" action="{{ route('currencies.destroy', $currency->id) }}" class="d-inline">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
