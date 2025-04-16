<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::create([
            ['nom' => 'Menu Classique', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Menu Végétarien', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
