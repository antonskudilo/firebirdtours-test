@extends('layouts.app')

@section('title', 'Создание валюты')

@section('content')
    <form method="POST" action="{{ route('currencies.store') }}">
        @csrf

        <div class="mb-3">
            <label for="code" class="form-label">Code</label>
            <input name="code" id="code" class="form-control" value="{{ old('code') }}" required>
        </div>

        <div class="mb-3">
            <label for="name_plural" class="form-label">Name plural</label>

            <input
                id="name_plural"
                name="name_plural"
                class="form-control"
                value="{{ old('name_plural') }}"
                required
            >
        </div>

        <button class="btn btn-success">Создать</button>
    </form>
@endsection
