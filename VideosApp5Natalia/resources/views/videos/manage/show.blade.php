@extends('layouts.app')

@section('content')
    <div style="padding: 20px;">
        <h1>Detalls del Vídeo</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $video->title }}</h5>
                <p class="card-text">{{ $video->description }}</p>
                <p><strong>URL:</strong> <a href="{{ $video->url }}" target="_blank">{{ $video->url }}</a></p>
                <a href="{{ route('videos.manage.edit', $video) }}" class="btn">Editar</a>
                <a href="{{ route('videos.manage.delete', $video) }}" class="btn">Eliminar</a>
                <a href="{{ route('videos.manage.index') }}" class="btn">Tornar a Gestió</a>
            </div>
        </div>
    </div>
@endsection
