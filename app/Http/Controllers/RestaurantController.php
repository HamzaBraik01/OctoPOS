<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $restaurants = Restaurant::all();
        return view('restaurants.index', compact('restaurants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('restaurants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
        ]);

        Restaurant::create($validated);

        return redirect()->route('restaurants.index')
            ->with('success', 'Restaurant créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Restaurant $restaurant)
    {
        return view('restaurants.show', compact('restaurant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Restaurant $restaurant)
    {
        return view('restaurants.edit', compact('restaurant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
        ]);

        $restaurant->update($validated);

        return redirect()->route('restaurants.index')
            ->with('success', 'Restaurant mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();

        return redirect()->route('restaurants.index')
            ->with('success', 'Restaurant supprimé avec succès.');
    }

    /**
     * Définir le restaurant actif dans la session
     */
    public function setRestaurant(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
        ]);
        
        session(['restaurant_id' => $request->restaurant_id]);
        
        // Récupérer le nom du restaurant pour le message de succès
        $restaurant = Restaurant::find($request->restaurant_id);
        
        return response()->json([
            'success' => true,
            'restaurant_name' => $restaurant->nom
        ]);
    }
    
    /**
     * Récupérer tous les restaurants pour le sélecteur (API)
     */
    public function getRestaurants()
    {
        $restaurants = Restaurant::all(['id', 'nom']);
        
        return response()->json($restaurants);
    }
}