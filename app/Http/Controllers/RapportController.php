<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RapportController extends Controller
{
    
    public function ventesMenusuelles(Request $request)
    {
        
        $restaurantId = $request->query('restaurant_id');
        $nomRestaurant = "Tous les restaurants";
        
        if ($restaurantId) {
            $restaurant = Restaurant::find($restaurantId);
            if ($restaurant) {
                $nomRestaurant = $restaurant->nom;
            }
        }

        
        $dateDebut = Carbon::now()->startOfMonth();
        $dateFin = Carbon::now()->endOfMonth();
        $moisActuel = Carbon::now()->format('F Y');

        $commandesQuery = Commande::query()
            ->where('statut', 'payée') 
            ->whereBetween('date', [$dateDebut, $dateFin]); 

        
        if ($restaurantId) {
            $userIds = User::where('restaurant_id', $restaurantId)->pluck('id')->toArray();
            if (!empty($userIds)) {
                $commandesQuery->whereIn('user_id', $userIds);
            }
        }

        $commandesParJour = $commandesQuery
            ->select(DB::raw('DATE(date) as date_vente'), DB::raw('COUNT(*) as nombre_commandes'))
            ->groupBy('date_vente')
            ->get()
            ->keyBy('date_vente');

        $joursComplets = [];
        $date = clone $dateDebut;
        $nombreCommandes = 0;
        
        $montantMoyenEstime = 150; 
        $totalVentes = 0;
        
        while ($date <= $dateFin) {
            $dateStr = $date->format('Y-m-d');
            
            if (isset($commandesParJour[$dateStr])) {
                $nbCommandes = $commandesParJour[$dateStr]->nombre_commandes;
                $montantJour = $nbCommandes * $montantMoyenEstime;
                
                $joursComplets[] = [
                    'date' => $dateStr,
                    'jour_semaine' => $date->format('l'),
                    'nombre_commandes' => $nbCommandes,
                    'total_ventes' => $montantJour
                ];
                
                $nombreCommandes += $nbCommandes;
                $totalVentes += $montantJour;
            } else {
                $joursComplets[] = [
                    'date' => $dateStr,
                    'jour_semaine' => $date->format('l'),
                    'nombre_commandes' => 0,
                    'total_ventes' => 0
                ];
            }
            
            $date->addDay();
        }
        
        $ticketMoyen = $nombreCommandes > 0 ? $totalVentes / $nombreCommandes : 0;

        $pdf = PDF::loadView('rapports.ventes-mensuelles', [
            'moisActuel' => $moisActuel,
            'joursComplets' => $joursComplets,
            'totalVentes' => $totalVentes,
            'nombreCommandes' => $nombreCommandes,
            'ticketMoyen' => $ticketMoyen,
            'nomRestaurant' => $nomRestaurant,
            'dateGeneration' => Carbon::now()->format('d/m/Y H:i')
        ]);

        return $pdf->download('Rapport_Ventes_' . Carbon::now()->format('Y-m') . '.pdf');
    }
}
