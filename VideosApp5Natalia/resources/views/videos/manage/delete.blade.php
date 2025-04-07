@extends('layouts.app')

@section('title', 'Eliminar Vídeo')

@section('content')
    <h1>Eliminar Vídeo</h1>
    <p>Estàs segur que vols eliminar el vídeo <strong>{{ $video->title }}</strong>?</p>
    <form method="POST" action="{{ route('videos.manage.destroy', $video->id) }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn" style="background-color: #dc3545;">Eliminar</button>
    </form>
    <a href="{{ route('videos.manage.index') }}" class="btn" style="margin-top: 1rem;">Tornar</a>
@endsection
