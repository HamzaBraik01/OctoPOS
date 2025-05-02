<?php

namespace App\Http\Middleware;

use Closure;

class PreventBackHistory
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        
        if ($request->isMethod('GET')) {
            return $response->header('Cache-Control', 'no-store, private, max-age=0')
                ->header('Pragma', 'no-cache')
                ->header('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT');
        }
        
        return $response;
    }
}