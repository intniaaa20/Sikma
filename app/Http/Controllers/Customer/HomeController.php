<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
<<<<<<< HEAD
use App\Models\Menu;
=======
>>>>>>> 11bef3afaaf72c1e50919d38cee6d046b0ef42c6

class HomeController extends Controller
{
    public function index()
    {
<<<<<<< HEAD
        $menus = Menu::where('is_available', true)
            ->whereNull('archived_at')
            ->get();
        return view('home', compact('menus'));
=======
        return view('home');
>>>>>>> 11bef3afaaf72c1e50919d38cee6d046b0ef42c6
    }
}
