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

        Cookie::queue('jwt_token', $token, 60 * 24, null, null, false, true); // 1 jour

        session(['jwt_token' => $token]);
    
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
        $token = auth('api')->getToken();
        
        Auth::logout();
        
        if ($token) {
            try {
                auth('api')->invalidate($token);
            } catch (\Exception $e) {
            }
        }
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        session()->forget(['jwt_token', 'user_id', 'user_role']);
        Cookie::queue(Cookie::forget('jwt_token'));
        
        return redirect('/')->with('message', 'Vous avez été déconnecté avec succès.')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

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