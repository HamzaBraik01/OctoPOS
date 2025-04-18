<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RestaurantSeeder extends Seeder
{
    public function run(): void
    {
        Restaurant::insert([
            ['nom' => 'Le Gourmet', 'adresse' => '123 Main Street', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Pizza Paradise', 'adresse' => '456 Side Street', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
