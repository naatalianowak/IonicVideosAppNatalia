<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registre - VideosApp</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body { background-color: #f3e5f5; font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .register-container { background-color: white; padding: 2rem; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); width: 100%; max-width: 400px; }
        .register-container h1 { text-align: center; color: #6a1b9a; margin-bottom: 1.5rem; }
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
<div class="register-container">
    <h1>Registre</h1>
    @if (session('status'))
        <div class="success-message">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
        <div class="error-message">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div class="form-group">
            <label for="password">Contrasenya</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirmar Contrasenya</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>
        <button type="submit" class="btn">Registrar-se</button>
    </form>
    <div class="links">
        <p>Ja tens compte? <a href="{{ route('login') }}">Inicia sessió</a></p>
        <p><a href="{{ route('terms') }}">Termes i Condicions</a></p>
        <p><a href="{{ route('home') }}">Tornar a l'Inici</a></p>
    </div>
</div>
</body>
</html>
