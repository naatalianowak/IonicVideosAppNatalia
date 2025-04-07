@extends('layouts.app')

@section('title', 'Gestió d\'Usuaris')

@section('content')
    <h1>Gestió d'Usuaris</h1>
    <div class="d-flex justify-content-between mb-3" style="width: 100%; max-width: 500px;">
        <form method="GET" action="{{ route('users.manage.index') }}" style="display: flex; gap: 10px;">
            <input type="text" name="search" placeholder="Cerca usuaris..." value="{{ request('search') }}" style="padding: 0.5rem; border-radius: 5px; border: 1px solid #ddd; flex-grow: 1;">
            <button type="submit" class="btn">Cercar</button>
        </form>
        <a href="{{ route('users.manage.create') }}" class="btn">Crear Nou Usuari</a>
    </div>
    @if (session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif
    @if ($users->isEmpty())
        <p>No hi ha usuaris disponibles.</p>
    @else
        <div style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; width: 100%;">
            @foreach ($users as $user)
                <div style="flex: 1 1 300px; padding: 1rem; border: 1px solid #ddd; border-radius: 5px; text-align: left;">
                    <h2 style="color: #6a1b9a; font-size: 1.5rem; margin-bottom: 0.5rem;">
                        @if ($user->hasRole('Super Admin'))
                            Super Admin
                        @elseif ($user->hasRole('Video Manager'))
                            Video Manager
                        @else
                            Regular
                        @endif
                    </h2>
                    <p style="margin-bottom: 1rem;">Email: {{ $user->email }}</p>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('users.manage.edit', $user->id) }}" class="btn">Editar</a>
                        <a href="{{ route('users.manage.delete', $user->id) }}" class="btn" style="background-color: #dc3545; border-color: #dc3545;">Eliminar</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    <a href="{{ route('dashboard') }}" class="btn" style="margin-top: 1rem;">Tornar al Dashboard</a>
@endsection
