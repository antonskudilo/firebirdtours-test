<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <div class="d-flex align-items-center">
                <a class="navbar-brand me-3" href="{{ route('currencies.index') }}">
                    Currency Admin
                </a>

                @auth
                    <x-navbar-links />
                @endauth
            </div>

            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button class="btn btn-outline-light btn-sm">
                        Выход
                    </button>
                </form>
            @endauth
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>
</body>
</html>
