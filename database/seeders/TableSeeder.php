<?php

namespace Database\Seeders;

use App\Models\Table;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Table::create([
            ['numero' => 1, 'capacite' => 4, 'disponible' => true,'type' =>'SallePrincipale', 'restaurant_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['numero' => 2, 'capacite' => 2, 'disponible' => true,'type' =>'Vip', 'restaurant_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['numero' => 3, 'capacite' => 3, 'disponible' => true,'type' =>'Terrasse', 'restaurant_id' => 1, 'created_at' => now(), 'updated_at' => now()],

        ]);
    }
}
