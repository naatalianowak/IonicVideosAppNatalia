@extends('layouts.app')

@section('content')
    <div style="padding: 20px;">
        <h1>Eliminar Usuari</h1>
        <p>Estàs segur que vols eliminar l'usuari "{{ $user->name }}"?</p>
        <form action="{{ route('users.manage.destroy', $user->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn" data-qa="user-delete-button">Sí, Eliminar</button>
            <a href="{{ route('users.manage.index') }}" class="btn">Cancelar</a>
        </form>
    </div>
@endsection
