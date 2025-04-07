@extends('layouts.app')

@section('title', 'Termes i Condicions')

@section('content')
    <h1>Termes i Condicions</h1>
    <p>Aquests són els termes i condicions de VideosApp...</p>
    <a href="{{ route('home') }}" class="btn">Tornar a l'Inici</a>
@endsection
