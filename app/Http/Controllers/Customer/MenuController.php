<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Menu; // Import model Menu
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        // Ambil menu yang tersedia dan tidak diarsipkan
        $menus = Menu::where('is_available', true)
            ->whereNull('archived_at')
            ->get();

        return view('menu.index', compact('menus'));
    }
}
