<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Add specific users for testing
        User::create([
            'first_name' => 'Propriétaire',
            'last_name' => 'Test',
            'email' => 'proprietaire@example.com',
            'phone' => '+1234567890',
            'restaurant_name' => 'Restaurant Propriétaire',
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // Password: "password"
            'role' => 'Propriétaires',
        ]);

        User::create([
            'first_name' => 'Gérant',
            'last_name' => 'Test',
            'email' => 'gerant@example.com',
            'phone' => '+0987654321',
            'restaurant_name' => 'Restaurant Gérant',
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // Password: "password"
            'role' => 'Gérants',
        ]);

        User::create([
            'first_name' => 'Serveur',
            'last_name' => 'Test',
            'email' => 'serveur@example.com',
            'phone' => '+1122334455',
            'restaurant_name' => 'Restaurant Serveur',
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // Password: "password"
            'role' => 'Serveurs',
        ]);

        User::create([
            'first_name' => 'Cuisinier',
            'last_name' => 'Test',
            'email' => 'cuisinier@example.com',
            'phone' => '+2233445566',
            'restaurant_name' => 'Restaurant Cuisinier',
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // Password: "password"
            'role' => 'Cuisiniers',
        ]);

        User::create([
            'first_name' => 'Client',
            'last_name' => 'Test',
            'email' => 'client@example.com',
            'phone' => '+3344556677',
            'restaurant_name' => 'Restaurant Client',
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // Password: "password"
            'role' => 'Clients',
        ]);
    }
}
