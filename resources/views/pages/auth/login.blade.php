@extends('layouts.app')

@section('title', __('pages.login'))

@section('content')
    <div class="row justify-content-center vh-100">
        <div class="col-md-4 m-auto">
            <div class="card">
                <div class="card-header text-center">
                    @lang('pages.login')
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="login" class="form-label">@lang('pages/login.fields.login')</label>

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
                            <label for="password" class="form-label">@lang('pages/login.fields.password')</label>
                            <input id="password" type="password" name="password" class="form-control" required>
                        </div>

                        <button class="btn btn-primary w-100">
                            @lang('actions.sign_in')
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
