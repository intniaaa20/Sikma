<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Order;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil semua order yang sudah selesai (done)
        $orders = Order::where('status', 'done')->get();

        // Hitung jumlah pesanan tiap menu dari field items (diasumsikan json array dengan key menu_id dan qty)
        $menuCounts = [];
        foreach ($orders as $order) {
            $items = json_decode($order->items, true);
            if (is_array($items)) {
                foreach ($items as $item) {
                    if (isset($item['menu_id'])) {
                        $menuCounts[$item['menu_id']] = ($menuCounts[$item['menu_id']] ?? 0) + ($item['qty'] ?? 1);
                    }
                }
            }
        }

        // Urutkan menu berdasarkan jumlah pesanan terbanyak dan ambil limit (misal 8 teratas)
        arsort($menuCounts);
        $favoriteMenuIds = array_slice(array_keys($menuCounts), 0, 8);
        $favoriteMenus = Menu::whereIn('id', $favoriteMenuIds)
            ->get()
            ->sortByDesc(function ($menu) use ($menuCounts) {
                return $menuCounts[$menu->id] ?? 0;
            });

        // Ambil menu hari ini
        $menusToday = Menu::where('is_today', true)->where('is_available', true)->get();

        // Ambil promo aktif (hanya yang sedang berjalan, limit 6)
        $today = now();
        $promotions = \App\Models\Promo::with('menus')
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->orderBy('start_date', 'desc')
            ->take(6)
            ->get();

        return view('home', compact('favoriteMenus', 'menusToday', 'promotions'));
    }
}
