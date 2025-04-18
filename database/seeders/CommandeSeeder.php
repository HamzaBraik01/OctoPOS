<?php

namespace Database\Seeders;

use App\Models\Commande;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CommandeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Commande::insert([
            ['date' => now(), 'statut' => 'en attente', 'users_id' => 1, 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
