<?php

namespace Database\Seeders;

use App\Models\Plat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class PlatSeeder extends Seeder
{
  
    public function run(): void
    {
        Plat::create([
            [
                'nom' => 'Poulet rôti',
                'description' => 'Poulet rôti aux herbes',
                'prix' => 90.50,
                'menu_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nom' => 'Salade Veggie',
                'description' => 'Salade de légumes frais',
                'prix' => 45.00,
                'menu_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
