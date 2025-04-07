@extends('layouts.app')

@section('title', 'Editar Vídeo')

@section('content')
    <h1>Editar Vídeo</h1>
    <form method="POST" action="{{ route('videos.manage.update', $video->id) }}">
        @csrf
        @method('PUT')
        <div style="margin-bottom: 1rem;">
            <label for="title" style="display: block; color: #4a4a4a;">Títol</label>
            <input type="text" id="title" name="title" value="{{ $video->title }}" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
        </div>
        <div style="margin-bottom: 1rem;">
            <label for="url" style="display: block; color: #4a4a4a;">URL</label>
            <input type="url" id="url" name="url" value="{{ $video->url }}" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
        </div>
        <div style="margin-bottom: 1rem;">
            <label for="description" style="display: block; color: #4a4a4a;">Descripció</label>
            <textarea id="description" name="description" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">{{ $video->description }}</textarea>
        </div>
        <button type="submit" class="btn">Actualitzar</button>
    </form>
    <a href="{{ route('videos.manage.index') }}" class="btn" style="margin-top: 1rem;">Tornar</a>
@endsection
