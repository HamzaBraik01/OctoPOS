<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\Reservation;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index()
    {
        $tables = Table::all(); 

        $grouped = $tables->groupBy('type');
        
        $top3ParSection = $grouped->map(function ($tables) {
            return $tables->take(3)->values(); // Garder seulement les 3 premières
        });
    
        return view('index', [
            'sections' => [
                'tables' => $top3ParSection,
            ]
        ]);
    }
    

    public function create()
    {
        // Généralement inutilisé avec les API
        return response()->json(['message' => 'Not implemented'], 501);
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required|integer',
            'capacite' => 'required|integer',
            'disponible' => 'required|boolean',
            'restaurant_id' => 'required|exists:restaurants,id',
            'type' => 'required|string'
        ]);

        $table = Table::create($request->all());

        return response()->json($table, 201);
    }

    public function show(Table $table)
    {
        return response()->json($table);
    }

    public function edit(Table $table)
    {
        return response()->json(['message' => 'Not implemented'], 501);
    }

    public function update(Request $request, Table $table)
    {
        $request->validate([
            'numero' => 'sometimes|integer',
            'capacite' => 'sometimes|integer',
            'disponible' => 'sometimes|boolean',
            'restaurant_id' => 'sometimes|exists:restaurants,id',
            'type' => 'sometimes|string'
        ]);

        $table->update($request->all());

        return response()->json($table);
    }

    public function destroy(Table $table)
    {
        $table->delete();
        return response()->json(['message' => 'Table supprimée avec succès.']);
    }
}
