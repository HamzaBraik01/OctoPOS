<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::insert([
            ['nom' => 'Menu Classique', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Menu Végétarien', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Menu Enfant', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Menu Découverte', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Menu Gourmand', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Menu Express', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}