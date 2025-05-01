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
        // Validate the request
        $validated = $request->validate([
            'table_id' => 'required|exists:tables,id',
            'restaurant_id' => 'required|exists:restaurants,id',
            'total' => 'required|numeric|min:0',
        ]);
        
        // Create a new commande
        $commande = Commande::create([
            'table_id' => $validated['table_id'],
            'restaurant_id' => $validated['restaurant_id'],
            'date' => now(),
            'statut' => 'en_cours',
            'utilisateur_id' => auth()->id(),
            'total' => $validated['total']
        ]);
        
        return response()->json([
            'success' => true,
            'commande_id' => $commande->id,
            'message' => 'Commande créée avec succès'
        ]);
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
