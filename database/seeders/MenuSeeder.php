<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        Menu::create([
            'name' => 'Ayam Bakar',
            'description' => 'Ayam bakar bumbu khas, enak dan gurih.',
            'price' => 25000,
            'image' => null,
            'is_available' => true,
            'categories' => ['Ayam', 'Bakar'],
        ]);
        Menu::create([
            'name' => 'Nasi Goreng',
            'description' => 'Nasi goreng spesial dengan telur dan ayam.',
            'price' => 18000,
            'image' => null,
            'is_available' => true,
            'categories' => ['Nasi', 'Goreng'],
        ]);
        Menu::create([
            'name' => 'Es Teh Manis',
            'description' => 'Minuman segar es teh manis.',
            'price' => 5000,
            'image' => null,
            'is_available' => true,
            'categories' => ['Minuman'],
        ]);
    }
}
