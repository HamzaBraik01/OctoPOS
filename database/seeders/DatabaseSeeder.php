<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Database\Seeders\MenuSeeder;
use Database\Seeders\PlatSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\TableSeeder;
use Database\Seeders\CommandeSeeder;
use Database\Seeders\RestaurantSeeder;
use Database\Seeders\ReservationSeeder;

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
