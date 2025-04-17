<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Get restaurant name filter from request
        $restaurantFilter = $request->input('restaurant');
        
        // Query base
        $tablesQuery = Table::query();
        
        // Apply restaurant filter if provided
        if ($restaurantFilter) {
            $tablesQuery->where('restaurant_id', $restaurantFilter);
        }
        
        // Get filtered tables
        $allTables = $tablesQuery->get();
        
        // Get only restaurants that have tables, for the filter dropdown
        $restaurantIds = Table::distinct('restaurant_id')->pluck('restaurant_id');
        $restaurantNames = Restaurant::whereIn('id', $restaurantIds)->pluck('nom', 'id');
        
       
        
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
        
        // Organize tables by type and availability
        foreach ($allTables as $table) {
            $type = $table->typeTable;
            if (strtolower($type) === 'salleprincipale' || strtolower($type) === 'standard') {
                $type = 'SallePrincipale';
            } elseif (strtolower($type) === 'vip') {
                $type = 'Vip';
            } elseif (strtolower($type) === 'terrasse') {
                $type = 'Terrasse';
            } else {
                $type = 'SallePrincipale'; 
            }
            
            if ($table->isDisponible()) {
                $tablesByType[$type]['available'][] = $table;
            } else {
                $tablesByType[$type]['unavailable'][] = $table;
            }
        }
        
        return view('index', compact('tablesByType', 'restaurantNames', 'restaurantFilter'));
    }
}