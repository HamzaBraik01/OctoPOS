<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommandePlatController extends Controller
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
            'commande_id' => 'required|exists:commandes,id',
            'plats' => 'required|array',
            'plats.*.plat_id' => 'required|exists:plats,id',
            'plats.*.quantite' => 'required|integer|min:1',
            'plats.*.notes' => 'nullable|string',
            'plats.*.options' => 'nullable|json',
        ]);

        $insertedItems = [];
        
        // Insert each plat item into commande_plat table
        foreach ($validated['plats'] as $platData) {
            $commandePlat = [
                'commande_id' => $validated['commande_id'],
                'plat_id' => $platData['plat_id'],
                'quantite' => $platData['quantite'],
                'notes' => $platData['notes'] ?? null,
                'options' => $platData['options'] ?? null,
            ];
            
            // Insert into the pivot table
            $insertedItem = \DB::table('commande_plat')->insert($commandePlat);
            $insertedItems[] = $insertedItem;
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Plats ajoutés à la commande avec succès',
            'items' => $insertedItems
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
