<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAuthTimestamp
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            // Check if user has a valid auth timestamp that's recent
            $lastActivity = session('last_activity');
            $maxIdleTime = config('session.lifetime') * 60; // Convert minutes to seconds
            
            // Si la dernière activité n'est pas définie, l'initialiser maintenant
            if (!$lastActivity) {
                session(['last_activity' => time()]);
            }
            // Vérifier si le temps d'inactivité dépasse la limite
            else if ((time() - $lastActivity) > $maxIdleTime) {
                Auth::logout();
                session()->flush();
                return redirect('/')->with('message', 'Votre session a expiré. Veuillez vous reconnecter.');
            }
            
            // Update timestamp for this request
            session(['last_activity' => time()]);
        }
        
        return $next($request);
    }
}