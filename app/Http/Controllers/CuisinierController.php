<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class CuisinierController extends Controller
{
    public function index(Request $request)
    {
        $restaurants = Restaurant::all();
        
        // Si un restaurant est déjà sélectionné en session, on le récupère
        $selectedRestaurantId = $request->session()->get('restaurant_id');
        
        if ($selectedRestaurantId) {
            $selectedRestaurant = Restaurant::find($selectedRestaurantId);
            
            return view('cuisiniers.dashboard', compact('restaurants', 'selectedRestaurant'));
        }
        
        return view('cuisiniers.dashboard', compact('restaurants'));
    }
    
    /**
     * Handle restaurant selection form submission
     */
    public function selectRestaurant(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id'
        ]);
        
        $restaurantId = $request->restaurant_id;
        $request->session()->put('restaurant_id', $restaurantId);
        
        $restaurant = Restaurant::findOrFail($restaurantId);
        $restaurants = Restaurant::all();
        $selectedRestaurant = $restaurant;
        
        return view('cuisiniers.dashboard', compact('restaurants', 'selectedRestaurant'));
    }
}
