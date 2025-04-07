<?php

use App\Http\Controllers\ApiMultimediaController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideosController;

Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/media', [ApiMultimediaController::class, 'store']); // Create
        Route::get('/media/my-videos', [ApiMultimediaController::class, 'myVideos']); // Read
        Route::put('/media/{id}', [ApiMultimediaController::class, 'update']); // Update
        Route::delete('/media/{id}', [ApiMultimediaController::class, 'destroy']); // Delete
    });
});
