<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    // Méthode pour la connexion
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return redirect()->back()->withErrors(['error' => 'Email ou mot de passe incorrect']);
        }

        $user = auth('api')->user();

        // Store token in cookie and session
        Cookie::queue('jwt_token', $token, 60 * 24, null, null, false, true); // 1 jour
        session(['jwt_token' => $token]);
        
        // Initialize user session data
        session(['user_id' => $user->id]);
        session(['user_role' => $user->role]);
        session(['last_activity' => time()]);
    
        switch ($user->role) {
            case 'propriétaire':
                return redirect('/proprietaires/dashboard');
            case 'gérant':
                return redirect('/gerants/dashboard');
            case 'serveur':
                return redirect('/serveurs/dashboard');
            case 'cuisinier':
                return redirect('/cuisiniers/dashboard');
            case 'client':
                return redirect('/clients/dashboard');
            default:
                return redirect('/');
        }
    }

    public function logout(Request $request)
    {
        // Logout from all guards
        Auth::logout();
        
        // Invalidate the session
        $request->session()->invalidate();
        
        // Regenerate CSRF token
        $request->session()->regenerateToken();
        
        // Clear any JWT tokens if using JWT
        if (auth('api')->check()) {
            auth('api')->logout();
        }
        
        // Clear cookies and session data
        session()->forget('jwt_token');
        Cookie::queue(Cookie::forget('jwt_token'));
        
        // Clear any other auth-related session data
        session()->forget('user_id');
        session()->forget('user_role');
        
        // Redirect with a flash message
        return redirect('/')->with('message', 'Vous avez été déconnecté avec succès.');
    }

    // Méthode pour obtenir l'utilisateur actuel
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    // Méthode pour rafraîchir le token
    public function refresh()
    {
        $token = auth('api')->refresh();
        Cookie::queue('jwt_token', $token, 60 * 24, null, null, false, true);
        session(['jwt_token' => $token]);
        return response()->json(['token' => $token]);
    }
}