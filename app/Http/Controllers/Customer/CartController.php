<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Menampilkan halaman keranjang
    public function show(Request $request)
    {
        $cartItems = $request->session()->get('cart', []);
        $totalPrice = 0;

        // Hitung total harga
        foreach ($cartItems as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        return view('cart.show', compact('cartItems', 'totalPrice'));
    }

    // Menambah item ke keranjang
    public function add(Request $request, Menu $menu)
    {
        // Validasi sederhana (opsional, bisa ditambahkan)
        if (!$menu->is_available || $menu->archived_at) {
            return redirect()->route('menu.index')->with('error', 'Menu tidak tersedia.');
        }

        $cart = $request->session()->get('cart', []);
        $menuId = $menu->id;

        // Jika item sudah ada, tambahkan quantity
        if (isset($cart[$menuId])) {
            $cart[$menuId]['quantity']++;
        } else {
            // Jika item baru, tambahkan ke cart
            $cart[$menuId] = [
                "name" => $menu->name,
                "quantity" => 1,
                "price" => $menu->price,
                // Tambahkan detail lain jika perlu, misal 'image'
            ];
        }

        $request->session()->put('cart', $cart);
        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan ke keranjang!');
    }

    // Mengupdate jumlah item di keranjang
    public function update(Request $request, $id)
    {
        $cart = $request->session()->get('cart');

        if (isset($cart[$id])) {
            // Validasi quantity
            $request->validate([
                'quantity' => 'required|integer|min:1'
            ]);
            $cart[$id]['quantity'] = $request->quantity;
            $request->session()->put('cart', $cart);
            return redirect()->route('cart.show')->with('success', 'Jumlah item berhasil diperbarui.');
        }

        return redirect()->route('cart.show')->with('error', 'Item tidak ditemukan di keranjang.');
    }

    // Menghapus item dari keranjang
    public function remove(Request $request, $id)
    {
        $cart = $request->session()->get('cart');

        if (isset($cart[$id])) {
            unset($cart[$id]);
            $request->session()->put('cart', $cart);
            return redirect()->route('cart.show')->with('success', 'Item berhasil dihapus dari keranjang.');
        }

        return redirect()->route('cart.show')->with('error', 'Item tidak ditemukan di keranjang.');
    }

    // Opsional: Mengosongkan keranjang
    public function clear(Request $request)
    {
        $request->session()->forget('cart');
        return redirect()->route('cart.show')->with('success', 'Keranjang berhasil dikosongkan.');
    }
}
