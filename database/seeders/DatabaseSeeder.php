<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@fxxtyschop.com'],
            [
                'name'     => 'Admin Fxxtyschop',
                'password' => Hash::make('Admin@12345'),
                'is_admin' => true,
            ]
        );

        $tel = Category::firstOrCreate(['slug' => 'telephones'], ['name' => 'Téléphones']);
        $pc  = Category::firstOrCreate(['slug' => 'ordinateurs'], ['name' => 'Ordinateurs']);
        $acc = Category::firstOrCreate(['slug' => 'accessoires'], ['name' => 'Accessoires']);

        $items = [
            [$tel->id, 'iPhone 14 128 Go', 'Apple', 450000, 10, 'Écran 6,1" OLED, 128 Go, double caméra 12 MP. État neuf, garantie 12 mois.'],
            [$tel->id, 'Samsung Galaxy S23', 'Samsung', 420000, 8, 'Écran AMOLED 6,1", 256 Go, triple caméra 50 MP. Livré avec chargeur.'],
            [$tel->id, 'Tecno Camon 20', 'Tecno', 120000, 15, '8 Go RAM, 256 Go, caméra 64 MP, batterie 5000 mAh.'],
            [$pc->id, 'HP EliteBook 840 G8', 'HP', 380000, 5, 'Core i5 11e gén., 16 Go RAM, SSD 512 Go, écran 14" Full HD.'],
            [$pc->id, 'MacBook Air M1', 'Apple', 650000, 4, 'Puce M1, 8 Go RAM, SSD 256 Go, autonomie jusqu\'à 15 h.'],
            [$pc->id, 'Dell Latitude 7420', 'Dell', 340000, 6, 'Core i7, 16 Go RAM, SSD 512 Go, clavier rétroéclairé.'],
            [$acc->id, 'Écouteurs sans fil', 'Xiaomi', 15000, 30, 'Bluetooth 5.3, boîtier de charge, autonomie 20 h.'],
            [$acc->id, 'Chargeur rapide 65W', 'Anker', 20000, 25, 'USB-C, compatible téléphones et ordinateurs portables.'],
        ];

        foreach ($items as [$cat, $name, $brand, $price, $stock, $desc]) {
            Product::firstOrCreate(
                ['name' => $name],
                [
                    'category_id' => $cat,
                    'brand'       => $brand,
                    'price'       => $price,
                    'stock'       => $stock,
                    'description' => $desc,
                    'is_active'   => true,
                ]
            );
        }
    }
}