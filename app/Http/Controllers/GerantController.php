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
            return response()->json(['data' => []]);
        }
        
        $startDate = Carbon::now()->subDays(6)->startOfDay();
        $endDate = Carbon::now()->endOfDay();
        
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
        
        return response()->json([
            'data' => $formattedData,
            'today_total' => $formattedData[count($formattedData) - 1]['sales'],
            'week_total' => round($salesData->sum('total_sales'), 2)
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
        $user = User::findOrFail($id);
        
        $hasReservations = Reservation::where('user_id', $id)->exists();
        $hasOrders = Commande::where('user_id', $id)->exists();
        
        if ($hasReservations || $hasOrders) {
            return response()->json([
                'success' => false,
                'message' => 'Impossible de supprimer cet utilisateur car il possède des réservations ou des commandes.'
            ], 422);
        }
        
        $user->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Utilisateur supprimé avec succès'
        ]);
    }
}
