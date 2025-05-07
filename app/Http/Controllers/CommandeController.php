<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\CommandePlat;
use App\Models\Plat;
use App\Models\Table;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CommandeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Form submission received:', $request->all());
    
        try {
            $validatedData = $request->validate([
                'table_id' => 'required|integer|exists:tables,id',
                'restaurant_id' => 'required|integer|exists:restaurants,id',
                'total' => 'required|numeric|min:0',
                'plats' => 'required|array',
                'plats.*.id' => 'required|integer|exists:plats,id',
                'plats.*.quantite' => 'required|integer|min:1',
                'plats.*.cuisson' => 'nullable|string|max:100',
                'plats.*.accompagnement' => 'nullable|string|max:100',
                'plats.*.notes' => 'nullable|string|max:255',
                'amount_paid' => 'required|numeric|min:0',
                'change_given' => 'nullable|numeric|min:0',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed:', $e->errors());
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    
        $userId = Auth::id() ?? 1; // Fallback to ID 1 if not logged in (for demo purposes)
        $now = Carbon::now();
        
        // Create the main commande record
        $commande = Commande::create([
            'date' => $now,
            'statut' => 'payée', // Set status to 'payée' for completed payments
            'user_id' => $userId,
            'table_id' => $validatedData['table_id'],
            'restaurant_id' => $validatedData['restaurant_id'],
            'montant_total' => $validatedData['total'],
            'methode_paiement' => 'Espèces', // Changed from 'cash' to 'Espèces'
        ]);
    
        // Create all associated plat records
        foreach ($validatedData['plats'] as $plat) {
            $options = [];
            
            // Add cuisson if provided
            if (!empty($plat['cuisson'])) {
                $options['cuisson'] = $plat['cuisson'];
            }
            
            // Add accompagnement if provided
            if (!empty($plat['accompagnement'])) {
                $options['accompagnement'] = $plat['accompagnement'];
            }
    
            // Utiliser DB::insert pour insérer directement avec created_at et updated_at
            DB::table('commande_plat')->insert([
                'commande_id' => $commande->id,
                'plat_id' => $plat['id'],
                'quantite' => $plat['quantite'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    
        // Save payment details to log
        Log::info('Espèces payment processed:', [
            'commande_id' => $commande->id,
            'amount_paid' => $request->input('amount_paid'),
            'change_given' => $request->input('change_given'),
        ]);
    
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Commande créée et payée avec succès.',
                'commande_id' => $commande->id
            ]);
        }
    
        // For web requests, redirect back to the dashboard
        return redirect()->route('serveur.dashboard')->with('success', 'Commande créée et payée avec succès.');
    }
}