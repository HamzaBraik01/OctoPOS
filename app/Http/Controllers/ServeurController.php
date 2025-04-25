<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Table;

class ServeurController extends Controller
{
    public function index(Request $request)
    {
        $restaurants = Restaurant::all();
        
        $tables = null;
        $selectedRestaurant = null;
        
        if ($request->session()->has('restaurant_id')) {
            $restaurantId = $request->session()->get('restaurant_id');
            $selectedRestaurant = Restaurant::find($restaurantId);
            
            if ($selectedRestaurant) {
                $tables = Table::where('restaurant_id', $restaurantId)
                    ->orderBy('numero', 'asc')
                    ->get();
            }
        }
        
        return view('serveurs.dashboard', compact('restaurants', 'tables', 'selectedRestaurant'));
    }
    
    public function selectRestaurant(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id'
        ]);
        
        $restaurantId = $request->restaurant_id;
        $request->session()->put('restaurant_id', $restaurantId);
        
        $restaurant = Restaurant::find($restaurantId);
        $tables = Table::where('restaurant_id', $restaurantId)
            ->orderBy('numero', 'asc')
            ->get();
        
        $tables->each(function($table) {
            $table->disponible = $table->isDisponible();
        });
        
        return response()->json([
            'success' => true,
            'tables' => $tables,
            'restaurant' => $restaurant->nom
        ]);
    }
}