<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    @auth
        <nav class="navbar navbar-dark bg-dark mb-4">
            <div class="container">
                <div class="d-flex align-items-center">
                    <a class="navbar-brand me-3" href="{{ route('currencies.index') }}">
                        @lang('pages.currencies.index')
                    </a>

                    <x-navbar-links />
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button class="btn btn-outline-light btn-sm">
                        @lang('actions.logout')
                    </button>
                </form>
            </div>
        </nav>
    @endauth

    <div class="container">
        @yield('content')
    </div>
</body>
</html>
