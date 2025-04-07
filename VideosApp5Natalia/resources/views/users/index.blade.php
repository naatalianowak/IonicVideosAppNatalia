@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1>Gestió d'Usuaris</h1>
        <div class="d-flex justify-content-between mb-3">
            <form method="GET" action="{{ route('users.manage.index') }}" style="margin-bottom: 1rem;">
                <input type="text" name="search" placeholder="Cerca usuaris..." value="{{ request('search') }}" style="padding: 0.5rem; border-radius: 5px; border: 1px solid #ddd;">
                <button type="submit" class="btn">Cercar</button>
            </form>
            <a href="{{ route('users.manage.create') }}" class="btn">Crear Nou Usuari</a>
        </div>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if ($users->isEmpty())
            <p>No hi ha usuaris disponibles.</p>
        @else
            <div style="display: flex; flex-wrap: wrap; gap: 20px;">
                @foreach ($users as $user)
                    <div style="flex: 1 1 300px; padding: 1rem; border: 1px solid #ddd; border-radius: 5px;">
                        <h2 style="color: #6a1b9a;">
                            @if ($user->hasRole('Super Admin'))
                                Super Admin
                            @elseif ($user->hasRole('Video Manager'))
                                Video Manager
                            @else
                                Regular
                            @endif
                        </h2>
                        <p>Email: {{ $user->email }}</p>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('users.manage.edit', $user->id) }}" class="btn">Editar</a>
                            <a href="{{ route('users.manage.delete', $user->id) }}" class="btn btn-danger">Eliminar</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        <a href="{{ route('dashboard') }}" class="btn" style="margin-top: 1rem;">Tornar al Dashboard</a>
    </div>
@endsection
