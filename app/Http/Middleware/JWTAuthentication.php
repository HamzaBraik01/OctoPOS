<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JWTAuthentication
{
// Modify your middleware to be less strict if needed
public function handle($request, Closure $next)
{
    try {
        // Only verify the token is present and valid
        auth('api')->parseToken()->authenticate();
        
        // Remove the additional check that might be causing issues
        // if (auth('api')->parseToken()->check() === false) {
        //    return redirect('/')->with('message', 'Session expired. Please log in again.');
        // }
    } catch (\Exception $e) {
        // Log the specific exception for debugging
        \Log::error('JWT Authentication error: ' . $e->getMessage());
        
        // For TokenInvalidException or TokenExpiredException, redirect
        return redirect('/')->with('message', 'Authentication required.');
    }
    
    return $next($request);
}

}