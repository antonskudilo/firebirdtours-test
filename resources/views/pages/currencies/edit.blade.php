@php
    /** @var App\Entities\CurrencyEntity $currency */
@endphp

@extends('layouts.app')

@section('title', 'Редактирование валюты')

@section('content')
    <form method="POST" action="{{ route('currencies.update', $currency->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="code" class="form-label">Code</label>
            <input name="code" id="code" class="form-control" value="{{ old('code', $currency->code) }}" required>
        </div>

        <div class="mb-3">
            <label for="name_plural" class="form-label">Name plural</label>

            <input
                id="name_plural"
                name="name_plural"
                class="form-control"
                value="{{ old('name_plural', $currency->namePlural) }}"
                required
            >
        </div>

        <button class="btn btn-primary">Сохранить</button>
    </form>
@endsection
