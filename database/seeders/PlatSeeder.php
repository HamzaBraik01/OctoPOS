<?php

namespace Database\Seeders;

use App\Models\Plat;
use Illuminate\Database\Seeder;

class PlatSeeder extends Seeder
{
    public function run(): void
    {
        Plat::insert([
            [
                'nom' => 'Poulet rôti',
                'description' => 'Poulet rôti aux herbes',
                'prix' => 90.50,
                'menu_id' => 1, // Correspond au "Menu Classique"
                'categorie' => 'Plats',
                'image' => 'https://images.pexels.com/photos/376464/pexels-photo-376464.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nom' => 'Salade Veggie',
                'description' => 'Salade de légumes frais',
                'prix' => 45.00,
                'menu_id' => 2, // Correspond au "Menu Végétarien"
                'categorie' => 'Entrées',
                'image' => 'https://images.pexels.com/photos/2097090/pexels-photo-2097090.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nom' => 'Tiramisu',
                'description' => 'Dessert italien à base de mascarpone',
                'prix' => 60.00,
                'menu_id' => 3, // Correspond au "Menu Enfant"
                'categorie' => 'Desserts',
                'image' => 'https://images.pexels.com/photos/852506/pexels-photo-852506.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nom' => 'Coca Cola',
                'description' => 'Boisson gazeuse rafraîchissante',
                'prix' => 20.00,
                'menu_id' => 4, // Correspond au "Menu Découverte"
                'categorie' => 'Boissons',
                'image' => 'https://images.pexels.com/photos/1256331/pexels-photo-1256331.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nom' => 'Vin Rouge',
                'description' => 'Vin rouge de Bordeaux',
                'prix' => 150.00,
                'menu_id' => 5, // Correspond au "Menu Gourmand"
                'categorie' => 'Vins',
                'image' => 'https://images.pexels.com/photos/2071421/pexels-photo-2071421.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nom' => 'Menu du Jour',
                'description' => 'Entrée + Plat + Dessert',
                'prix' => 120.00,
                'menu_id' => 6, // Correspond au "Menu Express"
                'categorie' => 'Menu du jour',
                'image' => 'https://images.pexels.com/photos/7788453/pexels-photo-7788453.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}