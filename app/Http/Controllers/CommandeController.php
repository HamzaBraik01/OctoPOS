<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        \Log::info('Form submission received:', $request->all());
    
        try {
            // Updated validation rules to include plat_id
            $validatedData = $request->validate([
                'table_id' => 'required|integer|exists:tables,id',
                'restaurant_id' => 'required|integer|exists:restaurants,id',
                'total' => 'required|numeric|min:0',
                'plats' => 'required|array',
                'plats.*.id' => 'required|integer|exists:plats,id', // Added validation for plat_id
                'plats.*.quantite' => 'required|integer|min:1',
                'plats.*.cuisson' => 'nullable|string|max:100',  // Added cooking preference
                'plats.*.accompagnement' => 'nullable|string|max:100', // Added side dish
                'plats.*.extras' => 'nullable|array', // Validate extras as array
                'plats.*.notes' => 'nullable|string|max:255',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed:', $e->errors());
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    
        // Create the order
        $commande = Commande::create([
            'date' => now(),
            'statut' => 'en attente', 
            'users_id' => auth()->id() ,
            'table_id' => $validatedData['table_id'],
            'restaurant_id' => $validatedData['restaurant_id'],
            'total' => $validatedData['total'],
        ]);
    
        // Build options array and create order items
        foreach ($validatedData['plats'] as $plat) {
            // Construct options array
            $options = [
                'cuisson' => $plat['cuisson'] ?? null,
                'accompagnement' => $plat['accompagnement'] ?? null,
                'extras' => $plat['extras'] ?? []
            ];
    
            // Create the order item with plat_id
            $commande->plats()->create([
                'plat_id' => $plat['id'], // Added plat_id
                'quantite' => $plat['quantite'],
                'options' => $options, // Store all customization options in the options JSON column
                'notes' => $plat['notes'] ?? null,
                
            ]);
        }
    
        // If request wants JSON (API call)
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Commande créée avec succès.',
                'commande_id' => $commande->id
            ], 201);
        }
    
        // For web requests
        return redirect()->route('serveurs.dashboard')->with('success', 'Commande créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Commande $commande)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Commande $commande)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Commande $commande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commande $commande)
    {
        //
    }
}
