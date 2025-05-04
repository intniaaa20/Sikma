<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class HomeController extends Controller
{
    public function index()
    {
        $menus = Menu::where('is_available', true)
            ->whereNull('archived_at')
            ->get();
        return view('home', compact('menus'));
    }
}
