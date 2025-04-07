@extends('layouts.app')

@section('title', 'Crear Usuari')

@section('content')
    <h1>Crear Usuari</h1>
    <form action="{{ route('users.manage.store') }}" method="POST" style="width: 100%; max-width: 500px;">
        @csrf
        <div class="mb-3">
            <label for="name" style="display: block; margin-bottom: 0.5rem;">Nom</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required style="width: 100%; padding: 0.5rem; border-radius: 5px; border: 1px solid #ddd;">
            @error('name')
            <div class="error-message mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="email" style="display: block; margin-bottom: 0.5rem;">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 0.5rem; border-radius: 5px; border: 1px solid #ddd;">
            @error('email')
            <div class="error-message mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="password" style="display: block; margin-bottom: 0.5rem;">Contrasenya</label>
            <input type="password" id="password" name="password" required style="width: 100%; padding: 0.5rem; border-radius: 5px; border: 1px solid #ddd;">
            @error('password')
            <div class="error-message mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="password_confirmation" style="display: block; margin-bottom: 0.5rem;">Confirmar Contrasenya</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required style="width: 100%; padding: 0.5rem; border-radius: 5px; border: 1px solid #ddd;">
        </div>
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn">Crear</button>
            <a href="{{ route('users.manage.index') }}" class="btn">Tornar</a>
        </div>
    </form>
@endsection
