@extends('layouts.app')

@section('title', 'Вход в админку')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-center">
                    Вход в админку
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="login" class="form-label">Логин</label>

                            <input
                                id="login"
                                type="text"
                                name="login"
                                class="form-control @error('login') is-invalid @enderror"
                                value="{{ old('login') }}"
                                required
                            >

                            @error('login')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль</label>
                            <input id="password" type="password" name="password" class="form-control" required>
                        </div>

                        <button class="btn btn-primary w-100">
                            Войти
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
