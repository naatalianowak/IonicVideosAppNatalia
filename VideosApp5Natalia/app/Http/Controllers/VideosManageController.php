<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideosManageController extends Controller
{
    public function index()
    {
        $videos = Video::all(); // Mostra tots els vídeos, independentment de l'usuari
        return view('videos.manage.index', compact('videos'));
    }

    public function create()
    {
        return view('videos.manage.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url',
            'description' => 'required|string',
        ]);

        Video::create([
            'title' => $request->title,
            'url' => $request->url,
            'description' => $request->description,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('videos.manage.index')->with('status', 'Vídeo creat correctament!');
    }

    public function edit($id)
    {
        $video = Video::findOrFail($id); // Qualsevol vídeo pot ser editat
        return view('videos.manage.edit', compact('video'));
    }

    public function update(Request $request, $id)
    {
        $video = Video::findOrFail($id); // Qualsevol vídeo pot ser actualitzat

        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url',
            'description' => 'required|string',
        ]);

        $video->update([
            'title' => $request->title,
            'url' => $request->url,
            'description' => $request->description,
        ]);

        return redirect()->route('videos.manage.index')->with('status', 'Vídeo actualitzat correctament!');
    }

    public function delete($id)
    {
        $video = Video::findOrFail($id); // Qualsevol vídeo pot ser eliminat
        return view('videos.manage.delete', compact('video'));
    }

    public function destroy($id)
    {
        $video = Video::findOrFail($id); // Qualsevol vídeo pot ser eliminat
        $video->delete();
        return redirect()->route('videos.manage.index')->with('status', 'Vídeo eliminat correctament!');
    }
}
