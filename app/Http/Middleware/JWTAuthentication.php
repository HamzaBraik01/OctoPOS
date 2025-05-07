<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Support\Facades\Cookie;

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
                    return redirect('/login')->withErrors(['error' => 'Session non valide, veuillez vous reconnecter']);
                }
            } else if (session()->has('jwt_token')) {
                // Fallback à la session
                JWTAuth::setToken(session('jwt_token'));
                $user = JWTAuth::authenticate();

                if (!$user) {
                    return redirect('/login')->withErrors(['error' => 'Session non valide, veuillez vous reconnecter']);
                }
            } else {
                return redirect('/login')->withErrors(['error' => 'Veuillez vous connecter pour accéder à cette page']);
            }
        } catch (TokenExpiredException $e) {
            // Si le token est expiré, essayez de le rafraîchir
            try {
                $refreshed = JWTAuth::refresh(JWTAuth::getToken());
                Cookie::queue('jwt_token', $refreshed, 60 * 24, null, null, false, true);
                session(['jwt_token' => $refreshed]);
                
                // Continuer avec le nouveau token
                return $next($request);
            } catch (\Exception $e) {
                return redirect('/login')->withErrors(['error' => 'Session expirée, veuillez vous reconnecter']);
            }
        } catch (TokenInvalidException $e) {
            return redirect('/login')->withErrors(['error' => 'Session invalide, veuillez vous reconnecter']);
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['error' => 'Erreur d\'authentification: ' . $e->getMessage()]);
        }

        return $next($request);
    }
}