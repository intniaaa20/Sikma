<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderController extends Controller
{
    // Menampilkan histori pesanan user yang sedang login
    public function index()
    {
        $orders = Order::where('customer_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();
        return view('order.index', compact('orders'));
    }

    // Menampilkan histori pesanan yang sudah selesai (done)
    public function history()
    {
        $orders = \App\Models\Order::where('customer_id', \Auth::id())
            ->where('status', 'done')
            ->orderByDesc('created_at')
            ->get();
        return view('order.history', compact('orders'));
    }

    // ADMIN: Menampilkan semua order dari semua user
    public function adminOrderHistory()
    {
        // Cek jika user bukan admin, redirect atau abort
        if (!auth()->user() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }
        $orders = Order::with('customer')->orderByDesc('created_at')->get();
        return view('admin.order-history', compact('orders'));
    }
}
