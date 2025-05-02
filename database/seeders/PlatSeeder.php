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

            // Nouveaux plats
            [
                'nom' => 'Steak Frites',
                'description' => 'Steak grillé accompagné de frites maison',
                'prix' => 110.00,
                'menu_id' => 1, // Correspond au "Menu Classique"
                'categorie' => 'Plats',
                'image' => 'https://images.pexels.com/photos/687824/pexels-photo-687824.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nom' => 'Soupe de Légumes',
                'description' => 'Soupe chaude aux légumes frais',
                'prix' => 35.00,
                'menu_id' => 2, // Correspond au "Menu Végétarien"
                'categorie' => 'Entrées',
                'image' => 'https://images.pexels.com/photos/1058633/pexels-photo-1058633.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nom' => 'Brownie au Chocolat',
                'description' => 'Gâteau au chocolat fondant',
                'prix' => 50.00,
                'menu_id' => 3, // Correspond au "Menu Enfant"
                'categorie' => 'Desserts',
                'image' => 'https://images.pexels.com/photos/1388899/pexels-photo-1388899.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nom' => 'Jus d\'Orange',
                'description' => 'Jus d\'orange frais pressé',
                'prix' => 25.00,
                'menu_id' => 4, // Correspond au "Menu Découverte"
                'categorie' => 'Boissons',
                'image' => 'https://images.pexels.com/photos/1092730/pexels-photo-1092730.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nom' => 'Bière Blonde',
                'description' => 'Bière blonde artisanale',
                'prix' => 80.00,
                'menu_id' => 5, // Correspond au "Menu Gourmand"
                'categorie' => 'Boissons',
                'image' => 'https://images.pexels.com/photos/461224/pexels-photo-461224.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nom' => 'Pizza Margherita',
                'description' => 'Pizza classique avec tomate, mozzarella et basilic',
                'prix' => 95.00,
                'menu_id' => 6, // Correspond au "Menu Express"
                'categorie' => 'Plats',
                'image' => 'https://images.pexels.com/photos/825661/pexels-photo-825661.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nom' => 'Crème Brûlée',
                'description' => 'Dessert crémeux avec croûte caramélisée',
                'prix' => 55.00,
                'menu_id' => 1, // Correspond au "Menu Classique"
                'categorie' => 'Desserts',
                'image' => 'https://images.pexels.com/photos/1070850/pexels-photo-1070850.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nom' => 'Ceviche de Poisson',
                'description' => 'Poisson mariné dans du citron vert avec des épices',
                'prix' => 130.00,
                'menu_id' => 2, // Correspond au "Menu Végétarien"
                'categorie' => 'Entrées',
                'image' => 'https://images.pexels.com/photos/949593/pexels-photo-949593.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nom' => 'Smoothie Fruits Rouges',
                'description' => 'Smoothie frais à base de fruits rouges',
                'prix' => 30.00,
                'menu_id' => 4, // Correspond au "Menu Découverte"
                'categorie' => 'Boissons',
                'image' => 'https://images.pexels.com/photos/578700/pexels-photo-578700.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nom' => 'Pâtes Carbonara',
                'description' => 'Pâtes à la crème, lardons et parmesan',
                'prix' => 85.00,
                'menu_id' => 6, // Correspond au "Menu Express"
                'categorie' => 'Plats',
                'image' => 'https://images.pexels.com/photos/1279330/pexels-photo-1279330.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}