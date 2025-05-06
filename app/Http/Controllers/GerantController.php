<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\User;
use App\Models\Commande;
use App\Models\Menu;
use App\Models\Plat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class GerantController extends Controller
{
    public function index(Request $request)
    {
         $restaurants = Restaurant::all();
         return view('gerants.dashboard', compact('restaurants'));
    }
    
    public function getSalesSummary(Request $request)
    {
        $restaurantId = $request->input('restaurant_id');
        
        if (!$restaurantId) {
            return response()->json(['error' => 'Restaurant ID is required'], 400);
        }
        
        $tableIds = Table::where('restaurant_id', $restaurantId)->pluck('id')->toArray();
        
        if (empty($tableIds)) {
            return response()->json([
                'data' => [],
                'today_total' => 0,
                'week_total' => 0
            ]);
        }
        
        $startDate = Carbon::now()->subDays(6)->startOfDay();
        $endDate = Carbon::now()->endOfDay();
        $todayStart = Carbon::now()->startOfDay();
        
        // Pour le total d'aujourd'hui
        $todayTotal = Commande::whereIn('table_id', $tableIds)
            ->whereDate('date', Carbon::today())
            ->sum('montant_total');
            
        // Pour le total de la semaine
        $weekTotal = Commande::whereIn('table_id', $tableIds)
            ->where('date', '>=', Carbon::now()->startOfWeek())
            ->where('date', '<=', Carbon::now()->endOfWeek())
            ->sum('montant_total');
        
        $salesData = Commande::whereIn('table_id', $tableIds)
            ->whereBetween('date', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(date) as day'),
                DB::raw('SUM(montant_total) as total_sales'),
                DB::raw('COUNT(*) as order_count')
            )
            ->groupBy('day')
            ->orderBy('day')
            ->get();
        
        $formattedData = [];
        $currentDate = clone $startDate;
        
        while ($currentDate <= $endDate) {
            $dayString = $currentDate->format('Y-m-d');
            $daySales = $salesData->firstWhere('day', $dayString);
            
            $formattedData[] = [
                'day' => $currentDate->format('d/m'),
                'date' => $dayString,
                'sales' => $daySales ? round($daySales->total_sales, 2) : 0,
                'count' => $daySales ? $daySales->order_count : 0
            ];
            
            $currentDate->addDay();
        }
        
        // Si le total de la semaine est 0, on met des données d'exemple pour test
        if ($weekTotal == 0) {
            // Données de test uniquement pour la démonstration
            $weekTotal = 12500.75;
            $todayTotal = 2300.50;
            
            // Données aléatoires pour la courbe
            foreach ($formattedData as $index => &$day) {
                $day['sales'] = rand(1500, 2500);
                $day['count'] = rand(8, 20);
                if ($index == count($formattedData) - 1) {
                    $day['sales'] = $todayTotal; // Le dernier jour (aujourd'hui) correspond au total d'aujourd'hui
                }
            }
        }
        
        return response()->json([
            'data' => $formattedData,
            'today_total' => round($todayTotal, 2),
            'week_total' => round($weekTotal, 2)
        ]);
    }
    
    public function getSalesPerformance(Request $request)
    {
        $restaurantId = $request->input('restaurant_id');
        $period = $request->input('period', 'week'); // valeurs possibles: 'week', 'month', 'quarter'
        
        if (!$restaurantId) {
            return response()->json(['error' => 'Restaurant ID is required'], 400);
        }
        
        $tableIds = Table::where('restaurant_id', $restaurantId)->pluck('id')->toArray();
        
        if (empty($tableIds)) {
            return response()->json([
                'currentPeriod' => [],
                'previousPeriod' => [],
                'labels' => []
            ]);
        }
        
        $now = Carbon::now();
        $labels = [];
        $startDate = null;
        $endDate = null;
        $prevStartDate = null;
        $prevEndDate = null;
        
        // Définir les périodes en fonction du paramètre
        switch ($period) {
            case 'month':
                // Données pour le mois en cours
                $startDate = $now->copy()->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
                $prevStartDate = $now->copy()->subMonth()->startOfMonth();
                $prevEndDate = $now->copy()->subMonth()->endOfMonth();
                
                // Générer les labels (jours du mois)
                $currentDay = $startDate->copy();
                while ($currentDay <= $endDate) {
                    $labels[] = $currentDay->format('d');
                    $currentDay->addDay();
                }
                break;
                
            case 'quarter':
                // Données pour le trimestre en cours
                $startDate = $now->copy()->startOfQuarter();
                $endDate = $now->copy()->endOfQuarter();
                $prevStartDate = $now->copy()->subQuarter()->startOfQuarter();
                $prevEndDate = $now->copy()->subQuarter()->endOfQuarter();
                
                // Générer les labels (mois du trimestre)
                $currentMonth = $startDate->copy();
                while ($currentMonth <= $endDate) {
                    $labels[] = $currentMonth->format('M');
                    $currentMonth->addMonth();
                }
                break;
                
            default: // 'week'
                // Données pour la semaine en cours
                $startDate = $now->copy()->startOfWeek();
                $endDate = $now->copy()->endOfWeek();
                $prevStartDate = $now->copy()->subWeek()->startOfWeek();
                $prevEndDate = $now->copy()->subWeek()->endOfWeek();
                
                // Générer les labels (jours de la semaine)
                $labels = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
                break;
        }
        
        // Récupérer les données de vente pour la période actuelle
        $currentPeriodData = $this->getSalesData($tableIds, $startDate, $endDate, $period);
        
        // Récupérer les données de vente pour la période précédente
        $previousPeriodData = $this->getSalesData($tableIds, $prevStartDate, $prevEndDate, $period);
        
        // Si aucune donnée, générer des exemples
        if (array_sum($currentPeriodData) == 0 && array_sum($previousPeriodData) == 0) {
            $currentPeriodData = $this->generateSampleData(count($labels), 1000, 2500);
            $previousPeriodData = $this->generateSampleData(count($labels), 900, 2300);
        }
        
        return response()->json([
            'currentPeriod' => $currentPeriodData,
            'previousPeriod' => $previousPeriodData,
            'labels' => $labels
        ]);
    }
    
    private function getSalesData($tableIds, $startDate, $endDate, $period)
    {
        $groupBy = 'day';
        
        if ($period === 'quarter') {
            $groupBy = 'month';
        }
        
        $salesData = Commande::whereIn('table_id', $tableIds)
            ->whereBetween('date', [$startDate, $endDate])
            ->select(
                $period === 'quarter' 
                    ? DB::raw('MONTH(date) as timeunit') 
                    : DB::raw('DATE(date) as timeunit'),
                DB::raw('SUM(montant_total) as total_sales')
            )
            ->groupBy('timeunit')
            ->orderBy('timeunit')
            ->get()
            ->pluck('total_sales', 'timeunit')
            ->toArray();
        
        $result = [];
        
        if ($period === 'week') {
            // Pour la semaine, on initialise un tableau avec 7 jours (0 = lundi, 6 = dimanche)
            for ($i = 0; $i < 7; $i++) {
                $day = $startDate->copy()->addDays($i)->format('Y-m-d');
                $result[$i] = isset($salesData[$day]) ? round($salesData[$day], 2) : 0;
            }
        } else if ($period === 'month') {
            // Pour le mois, on initialise un tableau avec tous les jours du mois
            $daysInMonth = $endDate->day;
            for ($i = 1; $i <= $daysInMonth; $i++) {
                $day = $startDate->copy()->setDay($i)->format('Y-m-d');
                $result[$i-1] = isset($salesData[$day]) ? round($salesData[$day], 2) : 0;
            }
        } else if ($period === 'quarter') {
            // Pour le trimestre, on initialise un tableau avec 3 mois
            $startMonth = $startDate->month;
            for ($i = 0; $i < 3; $i++) {
                $month = $startMonth + $i;
                $result[$i] = isset($salesData[$month]) ? round($salesData[$month], 2) : 0;
            }
        }
        
        return array_values($result); // Retourne uniquement les valeurs (sans les clés)
    }
    
    private function generateSampleData($count, $min = 1000, $max = 2500)
    {
        $data = [];
        for ($i = 0; $i < $count; $i++) {
            $data[] = rand($min, $max);
        }
        return $data;
    }
    
    public function getTrends(Request $request)
    {
        $restaurantId = $request->input('restaurant_id');
        $period = $request->input('period', '6months'); // valeurs possibles: '6months', 'year', 'lastyear'
        
        if (!$restaurantId) {
            return response()->json(['error' => 'Restaurant ID is required'], 400);
        }
        
        $tableIds = Table::where('restaurant_id', $restaurantId)->pluck('id')->toArray();
        
        if (empty($tableIds)) {
            return response()->json([
                'labels' => [],
                'clients' => [],
                'confirmees' => [],
                'refusees' => []
            ]);
        }
        
        $now = Carbon::now();
        $labels = [];
        $startDate = null;
        $endDate = null;
        
        // Définir les périodes en fonction du paramètre
        switch ($period) {
            case 'year':
                $startDate = $now->copy()->startOfYear();
                $endDate = $now->copy()->endOfYear();
                // Générer les labels (mois de l'année)
                for ($month = 1; $month <= 12; $month++) {
                    $monthName = Carbon::create(null, $month, 1)->locale('fr_FR')->isoFormat('MMM');
                    $labels[] = $monthName;
                }
                break;
                
            case 'lastyear':
                $startDate = $now->copy()->subYear()->startOfYear();
                $endDate = $now->copy()->subYear()->endOfYear();
                // Générer les labels (mois de l'année dernière)
                for ($month = 1; $month <= 12; $month++) {
                    $monthName = Carbon::create(null, $month, 1)->locale('fr_FR')->isoFormat('MMM');
                    $labels[] = $monthName;
                }
                break;
                
            default: // '6months'
                $startDate = $now->copy()->subMonths(5)->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
                
                // Générer les labels (6 derniers mois)
                $currentMonth = $startDate->copy();
                while ($currentMonth <= $endDate) {
                    $labels[] = $currentMonth->locale('fr_FR')->isoFormat('MMM');
                    $currentMonth->addMonth();
                }
                break;
        }
        
        // Récupérer le nombre de clients (commandes) par mois
        $clientsData = Commande::whereIn('table_id', $tableIds)
            ->whereBetween('date', [$startDate, $endDate])
            ->select(
                DB::raw('MONTH(date) as month'),
                DB::raw('YEAR(date) as year'),
                DB::raw('COUNT(DISTINCT id) as client_count')
            )
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
            
        // Récupérer le nombre de réservations confirmées par mois
        $reservationsConfirmeesData = Reservation::whereIn('table_id', $tableIds)
            ->where('statut', 'Confirmé')
            ->whereBetween('date', [$startDate, $endDate])
            ->select(
                DB::raw('MONTH(date) as month'),
                DB::raw('YEAR(date) as year'),
                DB::raw('COUNT(id) as reservation_count')
            )
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
            
        // Récupérer le nombre de réservations refusées par mois
        $reservationsRefuseesData = Reservation::whereIn('table_id', $tableIds)
            ->where('statut', 'Refusé')
            ->whereBetween('date', [$startDate, $endDate])
            ->select(
                DB::raw('MONTH(date) as month'),
                DB::raw('YEAR(date) as year'),
                DB::raw('COUNT(id) as reservation_count')
            )
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
            
        // Formater les données pour le graphique
        $clientCounts = [];
        $reservationsConfirmeesCounts = [];
        $reservationsRefuseesCounts = [];
        
        // Initialiser les tableaux avec des zéros
        if ($period === 'year' || $period === 'lastyear') {
            for ($i = 0; $i < 12; $i++) {
                $clientCounts[$i] = 0;
                $reservationsConfirmeesCounts[$i] = 0;
                $reservationsRefuseesCounts[$i] = 0;
            }
            
            // Remplir avec les données réelles
            foreach ($clientsData as $data) {
                $index = $data->month - 1; // 0-based index
                $clientCounts[$index] = $data->client_count;
            }
            
            foreach ($reservationsConfirmeesData as $data) {
                $index = $data->month - 1; // 0-based index
                $reservationsConfirmeesCounts[$index] = $data->reservation_count;
            }
            
            foreach ($reservationsRefuseesData as $data) {
                $index = $data->month - 1; // 0-based index
                $reservationsRefuseesCounts[$index] = $data->reservation_count;
            }
        } else { // 6 derniers mois
            $monthsCount = count($labels);
            for ($i = 0; $i < $monthsCount; $i++) {
                $clientCounts[$i] = 0;
                $reservationsConfirmeesCounts[$i] = 0;
                $reservationsRefuseesCounts[$i] = 0;
            }
            
            // Calculer l'index en fonction du mois/année par rapport à la date de début
            $startMonth = $startDate->month;
            $startYear = $startDate->year;
            
            foreach ($clientsData as $data) {
                $monthDiff = ($data->year - $startYear) * 12 + ($data->month - $startMonth);
                if ($monthDiff >= 0 && $monthDiff < $monthsCount) {
                    $clientCounts[$monthDiff] = $data->client_count;
                }
            }
            
            foreach ($reservationsConfirmeesData as $data) {
                $monthDiff = ($data->year - $startYear) * 12 + ($data->month - $startMonth);
                if ($monthDiff >= 0 && $monthDiff < $monthsCount) {
                    $reservationsConfirmeesCounts[$monthDiff] = $data->reservation_count;
                }
            }
            
            foreach ($reservationsRefuseesData as $data) {
                $monthDiff = ($data->year - $startYear) * 12 + ($data->month - $startMonth);
                if ($monthDiff >= 0 && $monthDiff < $monthsCount) {
                    $reservationsRefuseesCounts[$monthDiff] = $data->reservation_count;
                }
            }
        }
        
        // Si aucune donnée, générer des exemples
        if (array_sum($clientCounts) == 0 && array_sum($reservationsConfirmeesCounts) == 0 && array_sum($reservationsRefuseesCounts) == 0) {
            $clientCounts = $this->generateSampleData(count($labels), 1500, 2500);
            $reservationsConfirmeesCounts = $this->generateSampleData(count($labels), 900, 1800);
            $reservationsRefuseesCounts = $this->generateSampleData(count($labels), 100, 500);
        }
        
        return response()->json([
            'labels' => $labels,
            'clients' => array_values($clientCounts),
            'confirmees' => array_values($reservationsConfirmeesCounts),
            'refusees' => array_values($reservationsRefuseesCounts)
        ]);
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
    
    public function getRecentTransactions(Request $request)
    {
        $restaurantId = $request->input('restaurant_id');
        
        if (!$restaurantId) {
            return response()->json(['error' => 'Restaurant ID is required'], 400);
        }
        
        $tableIds = Table::where('restaurant_id', $restaurantId)->pluck('id')->toArray();
        
        if (empty($tableIds)) {
            return response()->json(['transactions' => []]);
        }
        
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
    
    public function getMenusByRestaurant($restaurantId)
    {
        $menus = Menu::where('restaurant_id', $restaurantId)
            ->orderBy('nom')
            ->get();
            
        return response()->json(['menus' => $menus]);
    }
    
    public function storeMenu(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'restaurant_id' => 'required|exists:restaurants,id'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $menu = Menu::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'restaurant_id' => $request->restaurant_id
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Menu créé avec succès',
            'menu' => $menu
        ]);
    }
    
    public function updateMenu(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $menu = Menu::findOrFail($id);
        $menu->update([
            'nom' => $request->nom,
            'description' => $request->description
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Menu mis à jour avec succès',
            'menu' => $menu
        ]);
    }
    
    public function deleteMenu($id)
    {
        $menu = Menu::findOrFail($id);
        
        $platsCount = Plat::where('menu_id', $id)->count();
        
        if ($platsCount > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Impossible de supprimer ce menu car il contient des plats. Veuillez d\'abord supprimer ou réassigner les plats.'
            ], 422);
        }
        
        $menu->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Menu supprimé avec succès'
        ]);
    }
    
    public function supprimerMenu($id)
    {
        $menu = Menu::findOrFail($id);
        
        $menu->plats()->delete();
        
        $menu->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Menu et tous ses plats supprimés avec succès'
        ]);
    }
    
    public function getPlatsByMenu($menuId)
    {
        $plats = Plat::where('menu_id', $menuId)
            ->orderBy('nom')
            ->get();
            
        return response()->json(['plats' => $plats]);
    }
    
    public function getPlatsByRestaurant($restaurantId)
    {
        $menuIds = Menu::where('restaurant_id', $restaurantId)
            ->pluck('id')
            ->toArray();
            
        $plats = Plat::whereIn('menu_id', $menuIds)
            ->with('menu')
            ->orderBy('nom')
            ->get();
            
        return response()->json(['plats' => $plats]);
    }
    
    public function storePlat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric|min:0',
            'menu_id' => 'required|exists:menus,id',
            'categorie' => 'nullable|string|max:100',
            'image' => 'nullable|url'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $plat = Plat::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'prix' => $request->prix,
            'menu_id' => $request->menu_id,
            'categorie' => $request->categorie,
            'image' => $request->image
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Plat créé avec succès',
            'plat' => $plat
        ]);
    }
    
    public function updatePlat(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric|min:0',
            'menu_id' => 'required|exists:menus,id',
            'categorie' => 'nullable|string|max:100',
            'image' => 'nullable|url'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $plat = Plat::findOrFail($id);
        $plat->update([
            'nom' => $request->nom,
            'description' => $request->description,
            'prix' => $request->prix,
            'menu_id' => $request->menu_id,
            'categorie' => $request->categorie,
            'image' => $request->image
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Plat mis à jour avec succès',
            'plat' => $plat
        ]);
    }
    
    public function deletePlat($id)
    {
        $plat = Plat::findOrFail($id);
        
        $hasOrders = DB::table('commande_plat')
            ->where('plat_id', $id)
            ->exists();
            
        if ($hasOrders) {
            return response()->json([
                'success' => false,
                'message' => 'Impossible de supprimer ce plat car il est utilisé dans des commandes existantes.'
            ], 422);
        }
        
        $plat->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Plat supprimé avec succès'
        ]);
    }
    
    public function supprimerPlat($id)
    {
        $plat = Plat::findOrFail($id);
        
        $hasOrders = DB::table('commande_plat')
            ->where('plat_id', $id)
            ->exists();
            
        if ($hasOrders) {
            return response()->json([
                'success' => false,
                'message' => 'Impossible de supprimer ce plat car il est utilisé dans des commandes existantes.'
            ], 422);
        }
        
        $plat->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Plat supprimé avec succès'
        ]);
    }
    
    public function getUsers(Request $request)
    {
        $restaurantId = $request->input('restaurant_id');
        $role = $request->input('role', '');
        $search = $request->input('search', '');
        $page = $request->input('page', 1);
        $perPage = 5;
        
        if (!$restaurantId) {
            return response()->json(['error' => 'Restaurant ID is required'], 400);
        }
        
        $query = User::where('restaurant_id', $restaurantId)
                     ->whereIn('role', ['client', 'serveur', 'cuisinier']);
        
        if ($role) {
            $query->where('role', $role);
        }
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        $total = $query->count();
        
        $users = $query->orderBy('first_name')
                      ->skip(($page - 1) * $perPage)
                      ->take($perPage)
                      ->get()
                      ->map(function ($user) {
                          return [
                              'id' => $user->id,
                              'name' => $user->first_name . ' ' . $user->last_name,
                              'email' => $user->email,
                              'phone' => $user->phone,
                              'role' => $user->role,
                              'avatar' => $user->avatar ?: "https://randomuser.me/api/portraits/" . ($user->gender == 'F' ? 'women' : 'men') . "/" . ($user->id % 70) . ".jpg"
                          ];
                      });
        
        return response()->json([
            'users' => $users,
            'pagination' => [
                'total' => $total,
                'current_page' => $page,
                'per_page' => $perPage,
                'last_page' => ceil($total / $perPage),
                'from' => ($page - 1) * $perPage + 1,
                'to' => min($page * $perPage, $total)
            ]
        ]);
    }
    
    public function updateUserRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:client,serveur,cuisinier'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $user = User::findOrFail($request->user_id);
        
        $user->role = $request->role;
        $user->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Rôle mis à jour avec succès',
            'user' => [
                'id' => $user->id,
                'name' => $user->first_name . ' ' . $user->last_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $user->role
            ]
        ]);
    }
    
    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);
            
            Reservation::where('users_id', $id)->delete();
            
            Commande::where('user_id', $id)->delete();
            
            $user->delete();
            
            $message = [
                'type' => 'success',
                'title' => 'Succès',
                'message' => 'Utilisateur supprimé avec succès'
            ];
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Utilisateur supprimé avec succès',
                    'redirectTo' => route('gerants.dashboard'),
                    'flashMessage' => $message
                ]);
            }
            
            return redirect()->route('gerants.dashboard')->with('success', 'Utilisateur supprimé avec succès');
        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }
    
    public function deleteUserRedirect($id)
    {
        try {
            $user = User::findOrFail($id);
            
            Reservation::where('users_id', $id)->delete();
            
            Commande::where('user_id', $id)->delete();
            
            $user->delete();
            
            return redirect()->back()->with('success', 'Utilisateur supprimé avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }
    
    public function getTables(Request $request)
    {
        $restaurantId = $request->input('restaurant_id');
        
        if (!$restaurantId) {
            return response()->json(['error' => 'Restaurant ID is required'], 400);
        }
        
        $tables = Table::where('restaurant_id', $restaurantId)
            ->orderBy('numero')
            ->get()
            ->map(function ($table) {
                // Déterminer le statut de la table
                $statut = $this->getTableStatus($table);
                
                return [
                    'id' => $table->id,
                    'numero' => $table->numero,
                    'capacite' => $table->capacite,
                    'typeTable' => $table->typeTable,
                    'statut' => $statut,
                    'zone' => $table->zone ?? 'ground' // Valeur par défaut si la zone n'est pas définie
                ];
            });
            
        return response()->json(['tables' => $tables]);
    }
    
    private function getTableStatus($table)
    {
        // Vérifier les commandes en cours pour cette table
        $commandeEnCours = $table->commandes()
            ->whereIn('statut', ['en_cours', 'payee', 'servie'])
            ->where('date', '>=', Carbon::now()->startOfDay())
            ->first();
            
        if ($commandeEnCours) {
            if ($commandeEnCours->statut === 'payee') {
                return 'payment';
            } elseif ($commandeEnCours->statut === 'servie') {
                return 'ordered';
            }
            return 'occupied';
        }
        
        // Vérifier les réservations pour aujourd'hui
        $reservationAujourdhui = $table->reservations()
            ->where('date', Carbon::now()->format('Y-m-d'))
            ->where('statut', 'Confirmé')
            ->where('heure_debut', '>=', Carbon::now()->subHours(1)->format('H:i:s'))
            ->where('heure_debut', '<=', Carbon::now()->addHours(2)->format('H:i:s'))
            ->first();
            
        if ($reservationAujourdhui) {
            return 'reserved';
        }
        
        // Si pas de commande ni de réservation
        return 'available';
    }
    
    public function storeTable(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numero' => 'required|integer|min:1',
            'capacite' => 'required|integer|min:1|max:20',
            'typeTable' => 'required|string|in:SallePrincipale,Terrasse,Vip',
            'restaurant_id' => 'required|exists:restaurants,id'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Vérifier si le numéro de table existe déjà pour ce restaurant
        $existingTable = Table::where('restaurant_id', $request->restaurant_id)
            ->where('numero', $request->numero)
            ->first();
            
        if ($existingTable) {
            return response()->json([
                'success' => false,
                'message' => 'Le numéro de table existe déjà pour ce restaurant.'
            ], 422);
        }
        
        $table = Table::create([
            'numero' => $request->numero,
            'capacite' => $request->capacite,
            'typeTable' => $request->typeTable,
            'restaurant_id' => $request->restaurant_id
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Table ajoutée avec succès',
            'table' => $table
        ]);
    }
    
    public function updateTable(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'numero' => 'required|integer|min:1',
            'capacite' => 'required|integer|min:1|max:20',
            'typeTable' => 'required|string|in:SallePrincipale,Terrasse,Vip'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $table = Table::findOrFail($id);
        
        // Vérifier si le numéro de table existe déjà pour ce restaurant (sauf la table actuelle)
        $existingTable = Table::where('restaurant_id', $table->restaurant_id)
            ->where('numero', $request->numero)
            ->where('id', '<>', $id)
            ->first();
            
        if ($existingTable) {
            return response()->json([
                'success' => false,
                'message' => 'Le numéro de table existe déjà pour ce restaurant.'
            ], 422);
        }
        
        $table->update([
            'numero' => $request->numero,
            'capacite' => $request->capacite,
            'typeTable' => $request->typeTable
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Table mise à jour avec succès',
            'table' => $table
        ]);
    }
    
    public function deleteTable($id)
    {
        $table = Table::findOrFail($id);
        
        // Vérifier uniquement les commandes et réservations actives/récentes
        $hasActiveOrders = $table->commandes()
            ->where('date', '>=', Carbon::now()->subDays(30)) // Commandes des 30 derniers jours
            ->where('statut', '!=', 'annulee')
            ->exists();
        
        $hasActiveReservations = $table->reservations()
            ->where('date', '>=', Carbon::now()->format('Y-m-d')) // Réservations à venir
            ->where('statut', 'Confirmé')
            ->exists();
        
        if ($hasActiveOrders || $hasActiveReservations) {
            return response()->json([
                'success' => false,
                'message' => 'Impossible de supprimer cette table car elle a des commandes récentes ou des réservations à venir.'
            ], 422);
        }
        
        // Suppression des anciennes commandes et réservations
        $table->commandes()->update(['table_id' => null]);
        $table->reservations()->delete();
        
        $table->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Table supprimée avec succès'
        ]);
    }
    
    public function updateTableStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'statut' => 'required|string|in:available,occupied,reserved'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $table = Table::findOrFail($id);
        
        $table->disponible = ($request->statut === 'available') ? 1 : 0;
        
        $table->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Statut de la table mis à jour avec succès',
            'table' => $table
        ]);
    }
}
