@extends('layouts.app')

@section('title', 'Llista de Vídeos')

@section('content')
    <h1>Llista de Vídeos</h1>
    <form method="GET" action="{{ route('videos.index') }}" style="margin-bottom: 1rem;">
        <input type="text" name="search" placeholder="Cerca vídeos..." value="{{ request('search') }}" style="padding: 0.5rem; border-radius: 5px; border: 1px solid #ddd;">
        <button type="submit" class="btn">Cercar</button>
    </form>
    @if ($videos->isEmpty())
        <p>No hi ha vídeos disponibles.</p>
    @else
        <div style="display: flex; flex-wrap: wrap; gap: 20px;">
            @foreach ($videos as $video)
                <div style="flex: 1 1 300px; padding: 1rem; border: 1px solid #ddd; border-radius: 5px;">
                    <h2 style="color: #6a1b9a;">{{ $video->title }}</h2>
                    <img src="{{ $video->getThumbnailUrl() }}" alt="{{ $video->title }}" style="width: 100%; border-radius: 5px;">
                    <p>{!! $video->description !!}</p>
                    <a href="{{ route('videos.show', $video->id) }}" class="btn">Veure Detalls</a>
                </div>
            @endforeach
        </div>
    @endif
    @auth
        <a href="{{ route('dashboard') }}" class="btn" style="margin-top: 1rem;">Tornar al Dashboard</a>
    @endauth
@endsection
