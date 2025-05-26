<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promo;
use App\Models\Menu;
use Carbon\Carbon;

class PromoSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil menu yang sudah ada
        $ayam = Menu::where('name', 'Ayam Bakar')->first();
        $nasi = Menu::where('name', 'Nasi Goreng')->first();
        $teh = Menu::where('name', 'Es Teh Manis')->first();

        // Buat promo bundle: Ayam Bakar + Nasi Goreng
        if ($ayam && $nasi) {
            $promo = Promo::create([
                'title' => 'Bundle Ayam + Nasi',
                'description' => 'Dapatkan diskon spesial untuk pembelian Ayam Bakar dan Nasi Goreng.',
                'poster_path' => null,
                'start_date' => Carbon::now()->subDay(),
                'end_date' => Carbon::now()->addMonth(),
                'discount' => 5000,
            ]);
            $promo->menus()->sync([$ayam->id, $nasi->id]);
        }

        // Buat promo minuman: Es Teh Manis
        if ($teh) {
            $promo = Promo::create([
                'title' => 'Diskon Es Teh',
                'description' => 'Diskon untuk pembelian Es Teh Manis.',
                'poster_path' => null,
                'start_date' => Carbon::now()->subDay(),
                'end_date' => Carbon::now()->addMonth(),
                'discount' => 1000,
            ]);
            $promo->menus()->sync([$teh->id]);
        }
    }
}
