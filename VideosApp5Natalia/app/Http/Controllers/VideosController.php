<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideosController extends Controller
{
    /**
     * Display a listing of videos.
     */
    public function index()
    {
        $videos = [
            [
                'id' => 1,
                'title' => 'Vídeo exemple 1',
                'description' => 'Vídeo per a proves.',
                'url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
            ],
            [
                'id' => 2,
                'title' => 'Vídeo exemple 2',
                'description' => 'Vídeo per a proves.',
                'url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
            ],
        ];

        return response()->json($videos);
    }

    /**
     * Store a newly uploaded video.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video' => 'required|file|mimes:mp4,avi,mov|max:102400',
        ]);

        $videoFile = $request->file('video');
        $path = $videoFile->store('videos', 'public');

        $video = [
            'title' => $request->title,
            'description' => $request->description,
            'url' => Storage::url($path),
        ];

        return response()->json([
            'message' => 'Video uploaded successfully',
            'video' => $video,
        ], 201);
    }
}
