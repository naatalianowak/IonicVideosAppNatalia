<?php

use App\Http\Controllers\UsersManageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VideosController;
use App\Http\Controllers\VideosManageController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/videos', [VideosController::class, 'index'])->name('videos.index');
Route::middleware(['auth'])->group(function () {
    Route::get('/videos/{video}', [VideosController::class, 'show'])->name('videos.show');
});

Route::get('/terms', function () {
    return view('terms');
})->name('terms');
Route::get('/policy', function () {
    return view('policy');
})->name('policy');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::middleware(['auth', 'can:manage videos'])->group(function () {
    Route::get('/videos/manage/index', [VideosManageController::class, 'index'])->name('videos.manage.index');
    Route::get('/videos/manage/create', [VideosManageController::class, 'create'])->name('videos.manage.create');
    Route::post('/videos/manage', [VideosManageController::class, 'store'])->name('videos.manage.store');
    Route::get('/videos/manage/{video}/edit', [VideosManageController::class, 'edit'])->name('videos.manage.edit');
    Route::put('/videos/manage/{video}', [VideosManageController::class, 'update'])->name('videos.manage.update');
    Route::get('/videos/manage/{video}/delete', [VideosManageController::class, 'delete'])->name('videos.manage.delete');
    Route::delete('/videos/manage/{video}', [VideosManageController::class, 'destroy'])->name('videos.manage.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('videos.index');
    })->name('dashboard');

    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [UsersController::class, 'show'])->name('users.show');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UsersController::class, 'show'])->name('users.show');
});

Route::middleware(['auth', 'can:manage users'])->group(function () {
    Route::get('/users/manage/index', [UsersManageController::class, 'index'])->name('users.manage.index');
    Route::get('/users/manage/create', [UsersManageController::class, 'create'])->name('users.manage.create');
    Route::post('/users/manage', [UsersManageController::class, 'store'])->name('users.manage.store');
    Route::get('/users/manage/{user}/edit', [UsersManageController::class, 'edit'])->name('users.manage.edit');
    Route::put('/users/manage/{user}', [UsersManageController::class, 'update'])->name('users.manage.update');
    Route::get('/users/manage/{user}/delete', [UsersManageController::class, 'delete'])->name('users.manage.delete');
    Route::delete('/users/manage/{user}', [UsersManageController::class, 'destroy'])->name('users.manage.destroy');
});
