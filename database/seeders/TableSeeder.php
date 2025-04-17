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
    Table::insert([
        ['numero' => 1, 'capacite' => 4, 'disponible' => true, 'typeTable' => 'SallePrincipale', 'restaurant_id' => 1, 'created_at' => now(), 'updated_at' => now()],
        ['numero' => 2, 'capacite' => 2, 'disponible' => true, 'typeTable' => 'Vip', 'restaurant_id' => 2, 'created_at' => now(), 'updated_at' => now()],
        ['numero' => 3, 'capacite' => 3, 'disponible' => true, 'typeTable' => 'Terrasse', 'restaurant_id' => 1, 'created_at' => now(), 'updated_at' => now()],
        ['numero' => 5, 'capacite' => 3, 'disponible' => false, 'typeTable' => 'Terrasse', 'restaurant_id' => 1, 'created_at' => now(), 'updated_at' => now()],
    ]);
}
}
