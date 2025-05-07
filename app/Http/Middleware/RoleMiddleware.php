<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Illuminate\Support\Facades\Cookie;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        try {
            $token = $request->cookie('jwt_token') ?? session('jwt_token');

            if (!$token) {
                return redirect('/login')->withErrors(['error' => 'Veuillez vous connecter pour accéder à cette page']);
            }

            JWTAuth::setToken($token);
            $user = JWTAuth::authenticate();

            if (!$user) {
                return redirect('/login')->withErrors(['error' => 'Session expirée, veuillez vous reconnecter']);
            }
            
            if (!in_array($user->role, $roles)) {
                // Rediriger vers la page correspondant au rôle de l'utilisateur au lieu de déconnecter
                switch ($user->role) {
                    case 'propriétaire':
                        return redirect('/proprietaires/dashboard')->withErrors(['error' => 'Vous n\'avez pas accès à cette section']);
                    case 'gérant':
                        return redirect('/gerants/dashboard')->withErrors(['error' => 'Vous n\'avez pas accès à cette section']);
                    case 'serveur':
                        return redirect('/serveurs/dashboard')->withErrors(['error' => 'Vous n\'avez pas accès à cette section']);
                    case 'cuisinier':
                        return redirect('/cuisiniers/dashboard')->withErrors(['error' => 'Vous n\'avez pas accès à cette section']);
                    case 'client':
                        return redirect('/clients/dashboard')->withErrors(['error' => 'Vous n\'avez pas accès à cette section']);
                    default:
                        return redirect('/')->withErrors(['error' => 'Vous n\'avez pas accès à cette section']);
                }
            }
        } catch (TokenExpiredException $e) {
            // Si le token est expiré, essayer de le rafraîchir
            try {
                $refreshed = JWTAuth::refresh(JWTAuth::getToken());
                Cookie::queue('jwt_token', $refreshed, 60 * 24, null, null, false, true);
                session(['jwt_token' => $refreshed]);
                
                // Continuer avec le nouveau token
                return $next($request);
            } catch (\Exception $e) {
                return redirect('/login')->withErrors(['error' => 'Session expirée, veuillez vous reconnecter']);
            }
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['error' => 'Erreur d\'authentification: ' . $e->getMessage()]);
        }

        return $next($request);
    }
}