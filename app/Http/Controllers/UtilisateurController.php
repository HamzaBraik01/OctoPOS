<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use App\Models\User;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UtilisateurController extends Controller
{
 

        // Make sure this method exists in this class
        public function update(Request $request)
        {
            // Validate the database fields
            $validated = $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore(Auth::id()),
                ],
                'phone' => ['nullable', 'string', 'max:20'],
            ]);
    
            // Update the authenticated user with validated data
            $user = Auth::user();
            $user->update($validated);
    
            // Store preferences in session
            $preferences = $request->only(['favorite_cuisine']);
            
            foreach ($preferences as $key => $value) {
                session([$key => $value]);
            }
    
            return redirect()->to('/clients/dashboard#profile')->with('status', 'profile-updated');
        }
    
      
    /**
     * Update the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        
        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);
        
        return redirect('clients/dashboard#profile')->with('success', 'Mot de passe mis à jour avec succès.');
    }
    
    /**
     * Delete the user's account.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);
        
        $user = Auth::user();
        
        Auth::logout();
        $user->delete();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'Votre compte a été supprimé avec succès.');
    }
    
  
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => ['required', 'image', 'max:1024'],
        ]);
        
        $user = Auth::user();
  
        $path = $request->file('photo')->store('profile-photos', 'public');
        
        if (Schema::hasColumn('users', 'profile_photo_path')) {
            // Delete old photo if exists
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            
            $user->update([
                'profile_photo_path' => $path,
            ]);
        } else {
            session(['profile_photo_path' => $path]);
        }
        
        return redirect('clients/dashboard#profile')->with('success', 'Photo de profil mise à jour avec succès.');
    }
}
