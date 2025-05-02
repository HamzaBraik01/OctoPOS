<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Table;
use App\Models\Restaurant;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        // Current user and date information
        $currentUser = auth()->user(); // Or use the provided login: HamzaBr01
        $currentDateTime = '2025-05-02 01:24:37'; // Using provided UTC datetime
        
        // Original table filtering functionality
        $restaurantFilter = $request->input('restaurant');
        $personsFilter = $request->input('persons');
        $dateFilter = $request->input('date', date('Y-m-d'));
        
        $tablesQuery = Table::query();
        
        if ($restaurantFilter) {
            $tablesQuery->where('restaurant_id', $restaurantFilter);
        }
        
        $allTablesForDropdown = $tablesQuery->get();
        
        if ($personsFilter) {
            if ($personsFilter === '9+') {
                $tablesQuery->where('capacite', '>=', 9);
            } else {
                $tablesQuery->where('capacite', '>=', (int)$personsFilter);
            }
        }
        
        $allTables = $tablesQuery->get();
        
        $restaurantIds = $allTablesForDropdown->pluck('restaurant_id')->unique();
        $restaurantNames = Restaurant::all()->pluck('nom', 'id');
        
        $tablesByType = [
            'SallePrincipale' => [
                'available' => [],
                'unavailable' => []
            ],
            'Vip' => [
                'available' => [],
                'unavailable' => []
            ],
            'Terrasse' => [
                'available' => [],
                'unavailable' => []
            ]
        ];
        
        // Get all reservations for the selected date
        $selectedDate = Carbon::parse($dateFilter);
        $reservations = Reservation::whereDate('date', $selectedDate->format('Y-m-d'))->get();
        
        // Group reservations by table_id
        $reservationsByTable = $reservations->groupBy('table_id');
        
        foreach ($allTables as $table) {
            $type = $table->typeTable;
            // Normalize table type
            if (strtolower($type) === 'salleprincipale' || strtolower($type) === 'standard') {
                $type = 'SallePrincipale';
            } elseif (strtolower($type) === 'vip') {
                $type = 'Vip';
            } elseif (strtolower($type) === 'terrasse') {
                $type = 'Terrasse';
            } else {
                $type = 'SallePrincipale'; // Default type
            }
            
            // Check if the table is available on the selected date
            $isAvailable = $this->isTableAvailableOnDate($table->id, $reservationsByTable, $selectedDate);
            
            if ($isAvailable) {
                $tablesByType[$type]['available'][] = $table;
            } else {
                $tablesByType[$type]['unavailable'][] = $table;
            }
        }
        
        $today = date('Y-m-d');
        
        // ----- ADDED DASHBOARD FUNCTIONALITY -----
        
        // Get client's user ID
        $userId = $currentUser->id;
        
        // 1. Total Reservations Count
        $totalReservationsCount = Reservation::where('id', $userId)->count();
        
        // 2. Calculate reservation growth compared to last month
        $lastMonth = Carbon::now()->subMonth();
        $twoMonthsAgo = Carbon::now()->subMonths(2);
        
        $currentMonthReservations = Reservation::where('id', $userId)
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->count();
            
        $lastMonthReservations = Reservation::where('id', $userId)
            ->whereMonth('date', $lastMonth->month)
            ->whereYear('date', $lastMonth->year)
            ->count();
        
        $reservationGrowth = $lastMonthReservations > 0 
            ? round((($currentMonthReservations - $lastMonthReservations) / $lastMonthReservations) * 100) 
            : 0;
        
        // 3. Upcoming Reservations
        $upcomingReservations = Reservation::where('id', $userId)
            ->where('date', '>=', Carbon::now()->format('Y-m-d'))
            ->orderBy('date')
            ->orderBy('heure_debut')
            ->take(3)
            ->get();
            
        $upcomingReservationsCount = $upcomingReservations->count();
        
        // 4. Weekly growth
        $thisWeekReservations = Reservation::where('id', $userId)
            ->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();
            
        $lastWeekReservations = Reservation::where('id', $userId)
            ->whereBetween('date', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])
            ->count();
        
        $weeklyGrowth = $lastWeekReservations > 0 
            ? round((($thisWeekReservations - $lastWeekReservations) / $lastWeekReservations) * 100) 
            : 0;
        
        // 5. Favorite Table
        $favoriteTableData = Reservation::where('id', $userId)
            ->select('table_id', DB::raw('count(*) as count'))
            ->groupBy('table_id')
            ->orderBy('count', 'desc')
            ->first();
        
        $favoriteTable = "Table #N/A";
        $favoriteTableCount = 0;
        
        if ($favoriteTableData) {
            $tableInfo = Table::find($favoriteTableData->table_id);
            $favoriteTable = $tableInfo ? "Table #{$tableInfo->numero}" : "Table #{$favoriteTableData->table_id}";
            $favoriteTableCount = $favoriteTableData->count;
        }
        
        // 6. Total Spent
        $totalSpent = 0;
        // Assuming there's an invoices or payments table linked to reservations
        // If such a table exists, you would query it like:
        /*
        $totalSpent = Invoice::where('user_id', $userId)->sum('amount');
        
        $lastMonthSpent = Invoice::where('user_id', $userId)
            ->whereMonth('date', $lastMonth->month)
            ->whereYear('date', $lastMonth->year)
            ->sum('amount');
            
        $twoMonthsAgoSpent = Invoice::where('user_id', $userId)
            ->whereMonth('date', $twoMonthsAgo->month)
            ->whereYear('date', $twoMonthsAgo->year)
            ->sum('amount');
        */
        
        // For demo purposes, using static data:
        $totalSpent = 387.20;
        $spendingGrowth = 8;
        
        // Format the reservation data for display
        foreach ($upcomingReservations as $reservation) {
            $tableInfo = Table::find($reservation->table_id);
            
            // Add formatted date/time
            $reservation->formatted_date = Carbon::parse($reservation->date)->format('d F Y');
            $reservation->formatted_time = Carbon::parse($reservation->heure_debut)->format('H:i');
            
            // Add table name
            $reservation->table_name = $tableInfo ? "Table #{$tableInfo->numero}" : "Table #{$reservation->table_id}";
            
            // Add reservation number (assuming there's a unique reservation ID or number)
            $reservation->reservation_number = 'RS' . str_pad($reservation->id, 5, '0', STR_PAD_LEFT);
        }
        
        // Pass data to view
        return view('clients.dashboard', compact(
            'tablesByType', 
            'restaurantNames', 
            'restaurantFilter', 
            'personsFilter', 
            'dateFilter', 
            'today',
            // Dashboard variables
            'totalReservationsCount',
            'upcomingReservationsCount',
            'reservationGrowth',
            'weeklyGrowth',
            'favoriteTable',
            'favoriteTableCount',
            'totalSpent',
            'spendingGrowth',
            'upcomingReservations',
            // Current user info
            'currentUser',
            'currentDateTime'
        ));
    }
    
    /**
     * Check if a table is available on a specific date based on reservation durations
     * 
     * @param int $tableId
     * @param Collection $reservationsByTable
     * @param Carbon $date
     * @return bool
     */
    private function isTableAvailableOnDate($tableId, $reservationsByTable, $date)
    {
        if (!isset($reservationsByTable[$tableId])) {
            return true;
        }
        
        $tableReservations = $reservationsByTable[$tableId];
        
        $totalReservedMinutes = 0;
        $reservedTimeSlots = [];
        
        foreach ($tableReservations as $reservation) {
            $startTime = Carbon::parse($reservation->date_reservation . ' ' . $reservation->heure_debut);
            $duration = $reservation->duree; 
            
            $reservedTimeSlots[] = [
                'start' => $startTime->format('H:i'),
                'end' => $startTime->copy()->addMinutes($duration)->format('H:i')
            ];
            
            $totalReservedMinutes += $duration;
        }
        
     
        $operatingMinutes = 720;
        
        if ($totalReservedMinutes >= $operatingMinutes) {
            return false;
        }
        
        usort($reservedTimeSlots, function($a, $b) {
            return strcmp($a['start'], $b['start']);
        });
        
        $conflictingReservations = false;
        for ($i = 0; $i < count($reservedTimeSlots) - 1; $i++) {
            if ($reservedTimeSlots[$i]['end'] > $reservedTimeSlots[$i + 1]['start']) {
                $conflictingReservations = true;
                break;
            }
        }
        
        return !$conflictingReservations;
    }
     

}
