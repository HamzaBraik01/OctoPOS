<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JWTAuthentication
{
    public function handle(Request $request, Closure $next)
    {
        try {
            // Vérifier si le token est dans le cookie
            if ($token = $request->cookie('jwt_token')) {
                JWTAuth::setToken($token);
                $user = JWTAuth::authenticate();

                if (!$user) {
                    return redirect('/login')->withErrors(['error' => 'Non authentifié']);
                }
            } else if (session()->has('jwt_token')) {
                // Fallback à la session
                JWTAuth::setToken(session('jwt_token'));
                $user = JWTAuth::authenticate();

                if (!$user) {
                    return redirect('/login')->withErrors(['error' => 'Non authentifié']);
                }
            } else {
                return redirect('/login')->withErrors(['error' => 'Non authentifié']);
            }
        } catch (TokenExpiredException $e) {
            // Si le token est expiré, essayez de le rafraîchir
            try {
                $refreshed = JWTAuth::refresh(JWTAuth::getToken());
                $request->cookie('jwt_token', $refreshed);
                session(['jwt_token' => $refreshed]);
            } catch (\Exception $e) {
                return redirect('/login')->withErrors(['error' => 'Session expirée']);
            }
        } catch (TokenInvalidException $e) {
            return redirect('/login')->withErrors(['error' => 'Token invalide']);
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['error' => 'Erreur d\'authentification']);
        }

        return $next($request);
    }
}