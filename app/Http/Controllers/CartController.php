<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $cart = session()->get('cart', []);
        $menus = Menu::whereIn('id', array_keys($cart))->get();
        return view('cart.index', compact('menus', 'cart'));
    }

    public function add(Request $request, Menu $menu)
    {
        $cart = session()->get('cart', []);
        $cart[$menu->id] = ($cart[$menu->id] ?? 0) + 1;
        session(['cart' => $cart]);
        return back()->with('success', 'Menu berhasil ditambahkan ke keranjang!');
    }

    public function remove(Request $request, Menu $menu)
    {
        $cart = session()->get('cart', []);
        unset($cart[$menu->id]);
        session(['cart' => $cart]);
        return back()->with('success', 'Menu dihapus dari keranjang.');
    }

    public function update(Request $request, Menu $menu)
    {
        $cart = session()->get('cart', []);
        $qty = max(1, (int) $request->input('qty', 1));
        $cart[$menu->id] = $qty;
        session(['cart' => $cart]);
        return back()->with('success', 'Jumlah menu diperbarui.');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Keranjang dikosongkan.');
    }
}
