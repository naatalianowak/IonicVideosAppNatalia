<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inici de Sessió - VideosApp</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body { background-color: #f3e5f5; font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-container { background-color: white; padding: 2rem; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); width: 100%; max-width: 400px; }
        .login-container h1 { text-align: center; color: #6a1b9a; margin-bottom: 1.5rem; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; color: #4a4a4a; margin-bottom: 0.5rem; }
        .form-group input { width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px; font-size: 1rem; }
        .btn { width: 100%; padding: 0.75rem; background-color: #ab47bc; color: white; border: none; border-radius: 5px; font-size: 1rem; cursor: pointer; transition: background-color 0.3s; }
        .btn:hover { background-color: #8e24aa; }
        .links { text-align: center; margin-top: 1rem; }
        .links a { color: #6a1b9a; text-decoration: none; }
        .links a:hover { text-decoration: underline; }
        .success-message, .error-message { padding: 1rem; margin-bottom: 1rem; border-radius: 5px; text-align: center; }
        .success-message { background-color: #d4edda; color: #155724; }
        .error-message { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
<div class="login-container">
    <h1>Inici de Sessió</h1>
    @if (session('status'))
        <div class="success-message">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="error-message">{{ session('error') }}</div>
    @endif
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div class="form-group">
            <label for="password">Contrasenya</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn">Iniciar Sessió</button>
    </form>
    <div class="links">
        <p>No tens compte? <a href="{{ route('register') }}">Registra't</a></p>
        <p><a href="{{ route('home') }}">Tornar a l'Inici</a></p>
    </div>
</div>
</body>
</html>
