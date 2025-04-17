<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $restaurantFilter = $request->input('restaurant');
        $personsFilter = $request->input('persons');
        
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
        
        return view('index', compact('tablesByType', 'restaurantNames', 'restaurantFilter', 'personsFilter'));
    }
}