@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Video</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <x-layouts.app>
            <form method="POST" action="{{ route('videos.update', ['video' => $video->id]) }}">
                @csrf
                @method('PUT')

                <div class="mt-4">
                    <x-label for="title" :value="__('Title')"/>
                    <x-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ $video->title }}"
                             required autofocus/>
                </div>

                <div class="mt-4">
                    <x-label for="description" :value="__('Description')"/>
                    <textarea id="description" class="block mt-1 w-full" name="description"
                              required>{{ $video->description }}</textarea>
                </div>

                <div class="mt-4">
                    <x-label for="url" :value="__('URL')"/>
                    <x-input id="url" class="block mt-1 w-full" type="url" name="url" value="{{ $video->url }}"
                             required/>
                </div>

                <div class="mt-4">
                    <x-label for="published_at" :value="__('Published At')"/>
                    <x-input id="published_at" class="block mt-1 w-full" type="datetime-local" name="published_at"
                             value="{{ $video->published_at?->format('Y-m-d\TH:i') }}" required/>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-button class="ml-4">
                        {{ __('Update Video') }}
                    </x-button>
                </div>
            </form>
        </x-layouts.app>
    </div>
@endsection
