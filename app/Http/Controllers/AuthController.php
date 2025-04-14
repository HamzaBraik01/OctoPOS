<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // Méthode pour la connexion
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return redirect()->back()->withErrors(['error' => 'Email ou mot de passe incorrect']);
        }

        $user = auth('api')->user();

        // Stocker le token JWT dans la session
        session(['jwt_token' => $token]);

        // Redirection basée sur le rôle
        switch ($user->role) {
            case 'Propriétaires':
                return redirect('/proprietaires/dashboard');
            case 'Gérants':
                return redirect('/gerants/dashboard');
            case 'Serveurs':
                return redirect('/serveurs/dashboard');
            case 'Cuisiniers':
                return redirect('/cuisiniers/dashboard');
            case 'Clients':
                return redirect('/clients/dashboard');
            default:
                return redirect('/home');
        }
    }

    // Méthode pour la déconnexion
    public function logout()
    {
        auth('api')->logout();
        session()->forget('jwt_token');
        return redirect('/');
    }
}
