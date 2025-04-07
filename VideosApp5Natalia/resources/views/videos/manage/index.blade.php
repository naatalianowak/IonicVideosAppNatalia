@extends('layouts.app')

@section('title', 'Gestionar Vídeos')

@section('content')
    <h1>Gestionar Vídeos</h1>
    <a href="{{ route('videos.manage.create') }}" class="btn" style="margin-bottom: 1rem;">Crear Vídeo</a>
    @if ($videos->isEmpty())
        <p>No hi ha vídeos per gestionar.</p>
    @else
        <div style="display: flex; flex-wrap: wrap; gap: 20px;">
            @foreach ($videos as $video)
                <div style="flex: 1 1 300px; padding: 1rem; border: 1px solid #ddd; border-radius: 5px;">
                    <h2 style="color: #6a1b9a;">{{ $video->title }}</h2>
                    <img src="{{ $video->getThumbnailUrl() }}" alt="{{ $video->title }}" style="width: 100%; border-radius: 5px;">
                    <p>{!! $video->description !!}</p>
                    <a href="{{ route('videos.manage.edit', $video->id) }}" class="btn">Editar</a>
                    <a href="{{ route('videos.manage.delete', $video->id) }}" class="btn" style="background-color: #dc3545;">Eliminar</a>
                </div>
            @endforeach
        </div>
    @endif
    <a href="{{ route('dashboard') }}" class="btn" style="margin-top: 1rem;">Tornar al Dashboard</a>
@endsection
