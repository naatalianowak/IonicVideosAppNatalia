@extends('layouts.app')

@section('title', $user->name)

@section('content')
    <h1>Detalls de {{ $user->name }}</h1>
    <p>Email: {{ $user->email }}</p>
    <h2 style="color: #6a1b9a; margin-top: 2rem;">Vídeos de l’Usuari</h2>
    @if ($user->videos->isEmpty())
        <p>Aquest usuari no ha publicat cap vídeo.</p>
    @else
        <div style="display: flex; flex-wrap: wrap; gap: 20px;">
            @foreach ($user->videos as $video)
                <div style="flex: 1 1 300px; padding: 1rem; border: 1px solid #ddd; border-radius: 5px;">
                    <h3 style="color: #6a1b9a;">{{ $video->title }}</h3>
                    <img src="{{ $video->getThumbnailUrl() }}" alt="{{ $video->title }}" style="width: 100%; border-radius: 5px;">
                    <p>{!! $video->description !!}</p>
                    <a href="{{ route('videos.show', $video->id) }}" class="btn">Veure Vídeo</a>
                </div>
            @endforeach
        </div>
    @endif
    <a href="{{ route('users.index') }}" class="btn" style="margin-top: 1rem;">Tornar a la Llista</a>
@endsection
