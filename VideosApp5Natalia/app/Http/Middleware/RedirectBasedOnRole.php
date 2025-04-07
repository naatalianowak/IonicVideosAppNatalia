<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectBasedOnRole
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            // Si l'usuari és Super Admin, redirigeix a /videos/manage
            if ($user->hasRole('Super Admin')) {
                return redirect()->route('videos.manage.index');
            }
            // Per a altres usuaris, redirigeix a /videos (pantalla pública)
            return redirect()->route('videos.index');
        }

        return $next($request);
    }
}
