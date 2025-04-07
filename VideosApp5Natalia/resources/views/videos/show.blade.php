@extends('layouts.app')

@section('title', $video->title)

@section('content')
    <h1>{{ $video->title }}</h1>
    <img src="{{ $video->getThumbnailUrl() }}" alt="{{ $video->title }}" style="width: 100%; max-width: 560px; border-radius: 5px; display: block; margin: 0 auto;">
    <p style="margin: 1rem 0; align-items: center; align-self: center">{!! $video->description !!}</p>
    <a href="{{ route('videos.index') }}" class="btn" style="align-self: center; align-items: center">Tornar a la Llista</a>
@endsection
