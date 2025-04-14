<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth('api')->user();

        if (!in_array($user->role, $roles)) {
            return redirect('/')->withErrors(['error' => 'Accès non autorisé']);
        }

        return $next($request);
    }
}