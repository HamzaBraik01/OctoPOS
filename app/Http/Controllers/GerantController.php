<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\User;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GerantController extends Controller
{
    public function index(Request $request)
    {
         $restaurants = Restaurant::all();
         return view('gerants.dashboard', compact('restaurants'));
    }
    
    public function getReservations(Request $request)
    {
        $restaurantId = $request->input('restaurant_id');
        
        if (!$restaurantId) {
            return response()->json(['error' => 'Restaurant ID is required'], 400);
        }
        
        $tableIds = Table::where('restaurant_id', $restaurantId)->pluck('id')->toArray();
        
        if (empty($tableIds)) {
            return response()->json(['reservations' => []]);
        }
        
        $reservations = Reservation::whereIn('table_id', $tableIds)
            ->with(['user', 'table'])
            ->orderBy('date', 'asc')
            ->orderBy('heure_debut', 'asc')
            ->get()
            ->map(function ($reservation) {
                return [
                    'id' => $reservation->id,
                    'heure' => date('H:i', strtotime($reservation->heure_debut)),
                    'client' => $reservation->user->first_name . ' ' . $reservation->user->last_name,
                    'telephone' => $reservation->user->phone,
                    'table' => 'Table ' . $reservation->table->numero,
                    'personnes' => $reservation->invite,
                    'statut' => $reservation->statut,
                    'date' => date('Y-m-d', strtotime($reservation->date))
                ];
            });
            
        return response()->json(['reservations' => $reservations]);
    }
    
    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:reservations,id',
            'statut' => 'required|in:En attente,Confirmé,Refusé'
        ]);
        
        $reservation = Reservation::findOrFail($request->id);
        $reservation->statut = $request->statut;
        $reservation->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Statut de la réservation mis à jour avec succès',
            'reservation' => [
                'id' => $reservation->id,
                'heure' => date('H:i', strtotime($reservation->heure_debut)),
                'client' => $reservation->user->first_name . ' ' . $reservation->user->last_name,
                'telephone' => $reservation->user->phone,
                'table' => 'Table ' . $reservation->table->numero,
                'personnes' => $reservation->invite,
                'statut' => $reservation->statut,
                'date' => date('Y-m-d', strtotime($reservation->date))
            ]
        ]);
    }
    
    /**
     * Get recent transactions for the cash register section
     */
    public function getRecentTransactions(Request $request)
    {
        $restaurantId = $request->input('restaurant_id');
        
        if (!$restaurantId) {
            return response()->json(['error' => 'Restaurant ID is required'], 400);
        }
        
        // Get tables belonging to the restaurant
        $tableIds = Table::where('restaurant_id', $restaurantId)->pluck('id')->toArray();
        
        if (empty($tableIds)) {
            return response()->json(['transactions' => []]);
        }
        
        // Get recent transactions (last 24 hours by default)
        $transactions = Commande::whereIn('table_id', $tableIds)
            ->where('date', '>=', Carbon::now()->subHours(24))
            ->orderBy('date', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($commande) {
                return [
                    'id' => $commande->id,
                    'date' => Carbon::parse($commande->date)->format('d/m/Y'),
                    'heure' => Carbon::parse($commande->date)->format('H:i'),
                    'table' => 'Table ' . ($commande->table ? $commande->table->numero : '?'),
                    'montant' => $commande->montant_total,
                    'methode_paiement' => $commande->methode_paiement,
                ];
            });
            
        return response()->json(['transactions' => $transactions]);
    }
}
