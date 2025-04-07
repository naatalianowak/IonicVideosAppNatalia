<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VideosApp - @yield('title')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body { background-color: #f3e5f5; font-family: Arial, sans-serif; margin: 0; }
        .navbar { background-color: #ab47bc; padding: 1rem; text-align: center; }
        .navbar a { color: white; margin: 0 1rem; text-decoration: none; }
        .navbar a:hover { text-decoration: underline; }
        .navbar form { display: inline; }
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        h1 { color: #6a1b9a; margin-bottom: 1.5rem; }
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background-color: #ab47bc;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn:hover { background-color: #8e24aa; }
        .success-message, .error-message { padding: 1rem; margin-bottom: 1rem; border-radius: 5px; width: 100%; max-width: 500px; }
        .success-message { background-color: #d4edda; color: #155724; }
        .error-message { background-color: #f8d7da; color: #721c24; }
        footer {
            background-color: #ab47bc;
            color: white;
            text-align: center;
            padding: 1rem;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        footer img {
            max-width: 100px;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
<nav class="navbar">
    <a href="{{ route('home') }}">Inici</a>
    <a href="{{ route('videos.index') }}">Vídeos</a>
    @if (auth()->user() && auth()->user()->hasPermissionTo('manage videos'))
        <a href="{{ route('videos.manage.index') }}">Gestionar Vídeos</a>
    @endif
    @auth
        <a href="{{ route('users.index') }}">Usuaris</a>
        @if (auth()->user() && auth()->user()->hasPermissionTo('manage users'))
            <a href="{{ route('users.manage.index') }}">Gestionar Usuaris</a>
        @endif
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn">Tancar Sessió</button>
        </form>
    @else
        <a href="{{ route('login') }}">Iniciar Sessió</a>
        <a href="{{ route('register') }}">Registrar-se</a>
    @endauth
</nav>
<div class="container">
    @if (session('status'))
        <div class="success-message">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="error-message">{{ session('error') }}</div>
    @endif
    @yield('content')
</div>
<footer>
    <p>© 2025 VideosApp. Tots els drets reservats.</p>
</footer>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
