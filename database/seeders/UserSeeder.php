<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Restaurant;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Get restaurants from database (should be seeded by RestaurantSeeder first)
        $leGourmet = Restaurant::where('nom', 'Le Gourmet')->first();
        $pizzaParadise = Restaurant::where('nom', 'Pizza Paradise')->first();
        
        // Ensure restaurants exist
        if (!$leGourmet || !$pizzaParadise) {
            $this->command->error('Restaurants not found. Please run RestaurantSeeder first.');
            return;
        }

        User::create([
            'first_name' => 'Propriétaire',
            'last_name' => 'Test',
            'email' => 'proprietaire@example.com',
            'phone' => '+1234567890',
            'restaurant_id' => $leGourmet->id,
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'role' => 'propriétaire',
        ]);
        
        User::create([
            'first_name' => 'Gérant',
            'last_name' => 'Test',
            'email' => 'gerant@example.com',
            'phone' => '+0987654321',
            'restaurant_id' => $pizzaParadise->id,
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'role' => 'gérant',
        ]);
        
        User::create([
            'first_name' => 'Serveur',
            'last_name' => 'Test',
            'email' => 'serveur@example.com',
            'phone' => '+1122334455',
            'restaurant_id' => $leGourmet->id,
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'role' => 'serveur',
        ]);
        
        User::create([
            'first_name' => 'Cuisinier',
            'last_name' => 'Test',
            'email' => 'cuisinier@example.com',
            'phone' => '+2233445566',
            'restaurant_id' => $pizzaParadise->id,
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'role' => 'cuisinier',
        ]);
        
        User::create([
            'first_name' => 'Client',
            'last_name' => 'Test',
            'email' => 'client@example.com',
            'phone' => '+3344556677',
            'restaurant_id' => $leGourmet->id,
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'role' => 'client',
        ]);
        
        User::create([
            'first_name' => 'Ali',
            'last_name' => 'Hamaina',
            'email' => 'ali@example.com',
            'phone' => '0600000000',
            'restaurant_id' => $leGourmet->id,
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'role' => 'client',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
