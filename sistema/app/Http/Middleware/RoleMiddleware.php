<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Permite continuar solo a usuarios que tengan uno de los roles indicados.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        abort_unless($user instanceof User && $user->hasRole(...$roles), 403);

        return $next($request);
    }
}
