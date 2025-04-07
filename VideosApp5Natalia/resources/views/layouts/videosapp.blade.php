<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'VideosApp') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        footer {
            background-color: #6f42c1; /* Morat com a la captura */
            color: white;
        }
        .btn {
            background-color: #6f42c1; /* Morat per als botons */
            border-color: #6f42c1;
            color: white;
        }
        .btn:hover {
            background-color: #5a32a3; /* Morat més fosc al fer hover */
            border-color: #5a32a3;
            color: white;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #c82333;
        }
    </style>
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">VideosApp</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Inici</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('videos.index') }}">Vídeos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.index') }}">Usuaris</a>
                </li>
                @auth
                    @if (auth()->user()->can('manage videos'))

                    @endif
                    @if (auth()->user()->can('manage users'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.manage.index') }}">Gestió d'Usuaris</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link">Tancar Sessió</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Iniciar Sessió</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Registre</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Contingut Principal -->
<main class="container mt-4">
    @yield('content')
</main>

<!-- Footer -->
<footer class="text-center py-3">
    <div class="container">
        <p>© 2025 VideosApp. Tots els drets reservats.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
