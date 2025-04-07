@extends('layouts.videosapp')

@section('content')
    <div class="container py-5">
        <h1>Detalls de l'Usuari</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $user->name }}</h5>
                <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
                <p class="card-text"><strong>Rol:</strong>
                    @if ($user->hasRole('Super Admin'))
                        Super Admin
                    @elseif ($user->hasRole('Video Manager'))
                        Video Manager
                    @else
                        Regular
                    @endif
                </p>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('users.manage.index') }}" class="btn">Tornar a la Llista</a>
                    @if (auth()->user()->hasRole('Super Admin'))
                        <a href="{{ route('users.manage.edit', $user->id) }}" class="btn">Editar</a>
                        <a href="{{ route('users.manage.delete', $user->id) }}" class="btn btn-danger">Eliminar</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
