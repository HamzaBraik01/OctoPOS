<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\View;

class JWTViewShare
{
    public function handle($request, Closure $next)
    {
        $isAuthenticated = false;
        $user = null;
        
        try {
            if ($token = $request->cookie('jwt_token') ?? session('jwt_token')) {
                JWTAuth::setToken($token);
                $user = JWTAuth::authenticate();
                $isAuthenticated = $user ? true : false;
            }
        } catch (\Exception $e) {
            $isAuthenticated = false;
        }
        
        View::share('isAuthenticated', $isAuthenticated);
        View::share('authUser', $user);
        
        return $next($request);
    }
}