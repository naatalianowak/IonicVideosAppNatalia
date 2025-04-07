@extends('layouts.app')

@section('title', 'Editar Usuari')

@section('content')
    <h1>Editar Usuari</h1>
    <form action="{{ route('users.manage.update', $user->id) }}" method="POST" style="width: 100%; max-width: 500px;">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" style="display: block; margin-bottom: 0.5rem;">Nom</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required style="width: 100%; padding: 0.5rem; border-radius: 5px; border: 1px solid #ddd;">
            @error('name')
            <div class="error-message mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="email" style="display: block; margin-bottom: 0.5rem;">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required style="width: 100%; padding: 0.5rem; border-radius: 5px; border: 1px solid #ddd;">
            @error('email')
            <div class="error-message mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn">Actualitzar</button>
            <a href="{{ route('users.manage.index') }}" class="btn">Tornar</a>
        </div>
    </form>
@endsection
