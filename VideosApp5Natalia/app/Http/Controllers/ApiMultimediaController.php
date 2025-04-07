<?php

namespace App\Http\Controllers;

use App\Models\Multimedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ApiMultimediaController extends Controller
{
    // Crear un vídeo (Create)
    public function store(Request $request)
    {
        Log::info('Received video upload request', [
            'title' => $request->title,
            'description' => $request->description,
            'has_file' => $request->hasFile('video'),
            'files' => $request->allFiles(),
            'user_id' => auth()->id(),
        ]);

        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'video' => 'required|file|mimes:mp4,avi,mov|max:102400',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        }

        $file = $request->file('video');
        if (!$file) {
            Log::error('No file received in request');
            return response()->json(['message' => 'No file received'], 400);
        }

        Log::info('File details', [
            'name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'mime' => $file->getMimeType(),
        ]);

        $path = $file->store('videos', 'public');
        if (!$path) {
            Log::error('Failed to store file');
            return response()->json(['message' => 'Failed to store file'], 500);
        }
        Log::info('File stored', ['path' => $path]);

        $userId = auth()->id();
        if (!$userId) {
            Log::error('No authenticated user found');
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $media = Multimedia::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $path,
            'user_id' => $userId,
        ]);

        Log::info('Media created', ['media_id' => $media->id, 'user_id' => $media->user_id]);

        return response()->json($media, 201);
    }

    // Llistar vídeos (Read)
    public function myVideos(Request $request)
    {
        $userId = auth()->id();
        if (!$userId) {
            Log::error('No authenticated user found for my-videos');
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        Log::info('Fetching videos for user', ['user_id' => $userId]);

        $videos = Multimedia::where('user_id', $userId)->get();

        Log::info('Videos fetched', ['count' => $videos->count(), 'videos' => $videos->toArray()]);

        return response()->json($videos);
    }

    // Actualitzar un vídeo (Update)
    public function update(Request $request, $id)
    {
        $userId = auth()->id();
        if (!$userId) {
            Log::error('No authenticated user found for update');
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $media = Multimedia::where('id', $id)->where('user_id', $userId)->first();
        if (!$media) {
            Log::error('Media not found or not authorized', ['id' => $id, 'user_id' => $userId]);
            return response()->json(['message' => 'Media not found or not authorized'], 404);
        }

        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        }

        $media->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        Log::info('Media updated', ['media_id' => $media->id, 'user_id' => $userId]);

        return response()->json($media);
    }

    // Eliminar un vídeo (Delete)
    public function destroy($id)
    {
        $userId = auth()->id();
        if (!$userId) {
            Log::error('No authenticated user found for delete');
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $media = Multimedia::where('id', $id)->where('user_id', $userId)->first();
        if (!$media) {
            Log::error('Media not found or not authorized', ['id' => $id, 'user_id' => $userId]);
            return response()->json(['message' => 'Media not found or not authorized'], 404);
        }

        // Eliminar el fitxer del sistema
        Storage::disk('public')->delete($media->file_path);

        // Eliminar el registre de la base de dades
        $media->delete();

        Log::info('Media deleted', ['media_id' => $id, 'user_id' => $userId]);

        return response()->json(['message' => 'Media deleted successfully']);
    }
}
