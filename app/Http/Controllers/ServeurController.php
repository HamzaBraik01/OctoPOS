<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Table;
use App\Models\Menu;
use App\Models\Plat;
use Carbon\Carbon;

class ServeurController extends Controller
{
    public function index(Request $request)
    {
        $restaurants = Restaurant::all();
        
        // Si un restaurant est déjà sélectionné en session, charger ses tables
        $selectedRestaurantId = $request->session()->get('restaurant_id');
        
        if ($selectedRestaurantId) {
            $selectedRestaurant = Restaurant::find($selectedRestaurantId);
            
            if ($selectedRestaurant) {
                $tables = Table::where('restaurant_id', $selectedRestaurantId)
                    ->orderBy('numero', 'asc')
                    ->get();
                
                // Préparer les tables avec leurs statuts
                $tables = $this->prepareTablesWithStatus($tables);
                
        
                $plats = Plat::with('menu')->get();
                $menus = Menu::all();
                
                return view('serveurs.dashboard', compact('restaurants', 'tables', 'selectedRestaurant', 'plats', 'menus'));
            }
        }
        
        return view('serveurs.dashboard', compact('restaurants'));
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
        $tables = Table::where('restaurant_id', $restaurantId)
            ->orderBy('numero', 'asc')
            ->get();
        
        // Prepare tables with status information
        $tables = $this->prepareTablesWithStatus($tables);
        
        $plats = Plat::with('menu')->get();
        $menus = Menu::all();
        
        $restaurants = Restaurant::all();
        $selectedRestaurant = $restaurant;
        
        return view('serveurs.dashboard', compact('restaurants', 'tables', 'selectedRestaurant', 'plats', 'menus'));
    }
    
    /**
     * Filtre les plats par catégorie de menu
     */
    public function filtrerPlats(Request $request)
    {
        $categorie = $request->categorie;
        
        $query = Plat::with('menu');
        
        if ($categorie && $categorie !== 'Tous') {
            $query->whereHas('menu', function($q) use ($categorie) {
                $q->where('nom', $categorie);
            });
        }
        
        $plats = $query->get();
        
        return response()->json([
            'success' => true,
            'plats' => $plats
        ]);
    }
    
    /**
     * Helper method to assign status to tables
     */
    private function prepareTablesWithStatus($tables)
    {
        return $tables->map(function($table) {
            // Check if the table is available today
            $isDisponible = $table->isDisponible();
            
            // Check for active reservations in the next hour
            $hasReservation = $table->reservations()
                ->whereDate('date', Carbon::today())
                ->where('date', '>=', Carbon::now())
                ->where('date', '<=', Carbon::now()->addHour())
                ->exists();
            
            // Determine status based on availability and reservations
            if (!$isDisponible) {
                $table->status = 'occupee'; // Occupied
                
                // Calculate time since occupation (random for demo)
                $table->occupation_time = rand(5, 60); // Minutes
                
                // Check if urgent (over 45 minutes)
                $table->is_urgent = $table->occupation_time > 45;
            } else if ($hasReservation) {
                $table->status = 'reservee'; // Reserved
                
                // Get next reservation time
                $nextReservation = $table->reservations()
                    ->whereDate('date', Carbon::today())
                    ->where('date', '>=', Carbon::now())
                    ->orderBy('date', 'asc')
                    ->first();
                
                $table->reservation_time = $nextReservation ? 
                    Carbon::parse($nextReservation->date)->format('H:i') : null;
            } else {
                $table->status = 'libre'; // Free
            }
            
            return $table;
        });
    }
}