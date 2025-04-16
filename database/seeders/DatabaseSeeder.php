<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    { $this->call([
        RestaurantSeeder::class,
        UserSeeder::class,
        MenuSeeder::class,
        PlatSeeder::class,
        TableSeeder::class,
        ReservationSeeder::class,
        CommandeSeeder::class,
        // CommandePlatSeeder::class,
    ]);
    }
}
