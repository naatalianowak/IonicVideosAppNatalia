<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VideosApp - Registre</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<nav class="navbar">
    <a href="{{ route('home') }}">Inici</a>
    <a href="{{ route('videos.index') }}">Vídeos</a>
    <a href="{{ route('login') }}">Iniciar Sessió</a>
    <a href="{{ route('register') }}">Registrar-se</a>
</nav>
<main>
    @yield('content')
</main>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
