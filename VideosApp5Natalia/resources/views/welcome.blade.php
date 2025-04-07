@extends('layouts.app')

@section('title', 'Benvingut')

@section('content')
    <h1>Benvingut a VideosApp</h1>
    <p>Explora els nostres vídeos i registra't per gestionar-los!</p>
    <div style="display: flex; flex-direction: row; justify-content: center; gap: 1rem;">
        <a href="{{ route('videos.index') }}" class="btn">Veure Vídeos</a>
        <a href="{{ route('users.index')}}" class="btn">Veure usuaris</a>
        @guest
            <a href="{{ route('register') }}" class="btn">Registrar-se</a>
            <a href="{{ route('login') }}" class="btn">Iniciar Sessió</a>
        @endguest

    </div>
    <img src="{{ asset('https://i.pinimg.com/originals/8d/8d/cb/8d8dcb9d29e7a7348aaade8e2b2d332e.gif') }}" alt="Benvingut a VideosApp" style="max-width: 320px; margin-top: 1rem; margin-left: 31rem; margin-right: auto; ">
@endsection
