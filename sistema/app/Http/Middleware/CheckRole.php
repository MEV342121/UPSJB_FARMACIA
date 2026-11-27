<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    // $roles recibe los nombres escritos en la ruta: ->middleware('role:Administrador,Cajero')
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Si el rol del usuario conectado no está en la lista: error 403 (prohibido)
        if (! $request->user()->hasRole(...$roles)) {
            abort(403);
        }

        // Si está en la lista: la petición sigue hacia el controlador
        return $next($request);
    }
}
