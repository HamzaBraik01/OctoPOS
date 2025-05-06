<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20'],
            'restaurant_id' => ['required', 'exists:restaurants,id'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['required', 'accepted'],
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'restaurant_id' => $request->restaurant_id,
            'password' => Hash::make($request->password),
            'role' => 'client'
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Store email in session for success page
        session()->flash('registered_email', $user->email);
        session()->flash('registration_success', true);

        return redirect(route('verification.notice'))
            ->with('registered_email', $user->email)
            ->with('registration_success', true);
    }

    public function create()
    {
        $restaurants = Restaurant::all();
        
        return view('auth.register', compact('restaurants'));
    }
}