<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        Reservation::insert([
            [
                'date' => now()->addDays(1), 
                'users_id' => 1, 
                'table_id' => 1, 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'date' => now()->addDays(2), 
                'users_id' => 2, 
                'table_id' => 2, 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'date' => now()->addDays(3), 
                'users_id' => 3, 
                'table_id' => 3, 
                'created_at' => now(), 
                'updated_at' => now()
            ]
        ]);
    }
}
