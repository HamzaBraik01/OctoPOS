<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Table;
use App\Models\Restaurant;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
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
        
        // Pass data to view - using the correct view name from the first implementation
        return view('clients.dashboard', compact(
            'tablesByType', 
            'restaurantNames', 
            'restaurantFilter', 
            'personsFilter', 
            'dateFilter', 
            'today'
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
