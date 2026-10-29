<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Verificamos usando la Facade Auth
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Si no es admin, denegamos el acceso
        abort(403, 'No tienes autorización para acceder a esta sección.');
    }
}