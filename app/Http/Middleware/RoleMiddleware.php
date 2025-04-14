<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        try {
            $token = $request->cookie('jwt_token') ?? session('jwt_token');

            if (!$token) {
                return redirect('/login')->withErrors(['error' => 'Non authentifié']);
            }

            JWTAuth::setToken($token);
            $user = JWTAuth::authenticate();

            if (!$user || !in_array($user->role, $roles)) {
                return redirect('/')->withErrors(['error' => 'Accès non autorisé']);
            }
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['error' => 'Erreur d\'authentification']);
        }

        return $next($request);
    }
}