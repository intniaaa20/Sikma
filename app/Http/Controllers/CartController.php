<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $cart = session()->get('cart', []);
        $cart = is_array($cart) ? $cart : [];
        $menus = \App\Models\Menu::whereIn('id', array_keys($cart))->get();
        return view('cart.index', compact('menus', 'cart'));
    }

    public function add(Request $request, Menu $menu)
    {
        $cart = session()->get('cart', []);
        // Pastikan $cart selalu array asosiatif id menu => qty
        if (!is_array($cart)) {
            $cart = [];
        }
        $menuId = (string) $menu->id;
        $cart[$menuId] = isset($cart[$menuId]) ? $cart[$menuId] + 1 : 1;
        session(['cart' => $cart]);
        $this->syncCartToDatabase($cart);
        return back()->with('success', 'Menu berhasil ditambahkan ke keranjang!');
    }

    public function remove(Request $request, Menu $menu)
    {
        $cart = session()->get('cart', []);
        unset($cart[$menu->id]);
        session(['cart' => $cart]);
        $this->syncCartToDatabase($cart);
        return back()->with('success', 'Menu dihapus dari keranjang.');
    }

    public function update(Request $request, Menu $menu)
    {
        $cart = session()->get('cart', []);
        $qty = max(1, (int) $request->input('qty', 1));
        $cart[$menu->id] = $qty;
        session(['cart' => $cart]);
        $this->syncCartToDatabase($cart);

        // Hitung subtotal dan total
        $menus = Menu::whereIn('id', array_keys($cart))->get();
        $subtotal = $menus->where('id', $menu->id)->first()->price * $qty;
        $total = 0;
        foreach ($cart as $id => $q) {
            $m = $menus->where('id', $id)->first();
            if ($m) $total += $m->price * $q;
        }

        // Jika AJAX, return JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'subtotal' => 'Rp ' . number_format($subtotal, 0, ',', '.'),
                'total' => 'Rp ' . number_format($total, 0, ',', '.'),
            ]);
        }

        // Jika bukan AJAX, redirect seperti biasa
        return back()->with('success', 'Jumlah menu diperbarui.');
    }

    public function clear()
    {
        session()->forget('cart');
        $this->syncCartToDatabase([]);
        return back()->with('success', 'Keranjang dikosongkan.');
    }

    public function checkout(Request $request)
    {
        $cart = session('cart', []);
        $selected = $request->input('selected', []);
        $menus = Menu::whereIn('id', $selected)->get();
        $user = Auth::user();
        $address = $user->address ?? '';
        return view('cart.checkout', compact('menus', 'cart', 'selected', 'address'));
    }

    public function processCheckout(Request $request)
    {
        $user = Auth::user();
        if ($user && $user instanceof \App\Models\User && $request->address && $user->address !== $request->address) {
            $user->address = $request->address;
            $user->save();
        }
        // Ambil data cart dari session
        $cart = session('cart', []);
        if (!is_array($cart)) {
            $cart = [];
        }
        $selected = $request->input('selected', array_keys($cart));
        $menus = Menu::whereIn('id', $selected)->get();
        $total = 0;
        $items = [];
        foreach ($menus as $menu) {
            $qty = $cart[$menu->id] ?? 1;
            $items[] = [
                'menu_id' => $menu->id,
                'name' => $menu->name,
                'price' => $menu->price,
                'qty' => $qty,
            ];
            $total += $menu->price * $qty;
        }
        // Simpan order ke database
        $order = new \App\Models\Order();
        $order->customer_id = $user->id;
        $order->total = $total;
        $order->status = 'pending';
        $order->address = $request->address;
        $order->note = $request->note;
        $order->delivery = $request->delivery;
        $order->payment = $request->payment;
        $order->items = json_encode($items);
        $order->payment_detail = json_encode([
            'payment' => $request->payment,
            'bank' => $request->bank ?? null,
            'va_number' => isset($order->va_number) ? $order->va_number : null,
            'total' => $total,
        ]);
        // Simpan tanggal pengiriman sebagai timestamp (jika ada)
        if ($request->filled('delivery_date')) {
            $order->delivery_date = $request->input('delivery_date') . ' 00:00:00';
        }
        // Jika virtual account (transfer), integrasi ke API BNI
        if ($request->payment === 'transfer') {
            $bniResponse = $this->createBniVa($order);
            if ($bniResponse['success']) {
                $order->va_number = $bniResponse['va_number'];
            } else {
                return back()->with('error', 'Gagal membuat Virtual Account BNI.');
            }
        }
        // Integrasi Midtrans Snap
        if ($request->payment === 'midtrans') {
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $snapParams = [
                'transaction_details' => [
                    'order_id' => 'ORDER-' . uniqid() . '-' . time(),
                    'gross_amount' => $total,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone ?? '',
                    'address' => $request->address,
                ],
                'item_details' => array_map(function ($item) {
                    return [
                        'id' => $item['menu_id'],
                        'price' => $item['price'],
                        'quantity' => $item['qty'],
                        'name' => $item['name'],
                    ];
                }, $items),
            ];
            $snapToken = \Midtrans\Snap::getSnapToken($snapParams);
            $order->payment_detail = json_encode([
                'payment' => 'midtrans',
                'snap_token' => $snapToken,
                'total' => $total,
            ]);
        }
        $order->save();
        // Kirim notifikasi ke admin
        $admin = User::role('admin')->first();
        if ($admin) {
            Notification::create([
                'user_id' => $admin->id,
                'message' => 'Pesanan baru dari ' . $user->name . ' (Order #' . $order->id . ')',
            ]);
        }
        session()->forget('cart');
        // Redirect ke halaman instruksi VA jika transfer
        if ($request->payment === 'transfer') {
            return redirect()->route('checkout.bni_va', ['order' => $order->id]);
        }
        // Redirect ke halaman Midtrans jika pembayaran Midtrans
        if ($request->payment === 'midtrans') {
            return redirect()->route('checkout.midtrans', ['order' => $order->id]);
        }
        return redirect()->route('cart.index')->with('success', 'Pesanan berhasil dibuat!');
    }

    protected function createBniVa($order)
    {
        try {
            $response = Http::withHeaders([
                'X-API-KEY' => 'cced5984-eef9-4eec-b67f-e2d98c2cd8bd',
                'Accept' => 'application/json',
            ])->post('https://apibeta.bni-ecollection.com/va/create', [
                'trx_id' => $order->id,
                'trx_amount' => (int) $order->total,
                'customer_name' => $order->address,
                // Tambahkan parameter lain sesuai kebutuhan API BNI
            ]);
            if ($response->successful() && isset($response['data']['virtual_account'])) {
                return [
                    'success' => true,
                    'va_number' => $response['data']['virtual_account'],
                ];
            }
        } catch (\Exception $e) {
        }
        return ['success' => false];
    }

    public function deleteSelected(Request $request)
    {
        $selected = explode(',', $request->input('selected', ''));
        $cart = session('cart', []);
        foreach ($selected as $id) {
            unset($cart[$id]);
        }
        session(['cart' => $cart]);
        $this->syncCartToDatabase($cart);
        return back()->with('success', 'Item terpilih berhasil dihapus dari keranjang.');
    }

    public function orderList()
    {
        $orders = Order::where('customer_id', Auth::id())->orderByDesc('created_at')->get();
        return view('order.index', compact('orders'));
    }

    public function showMidtransPayment($orderId)
    {
        $order = \App\Models\Order::findOrFail($orderId);
        $snapToken = null;
        if ($order->payment === 'midtrans') {
            $detail = json_decode($order->payment_detail, true);
            $snapToken = $detail['snap_token'] ?? null;
        }
        if (!$snapToken) {
            return redirect()->route('cart.index')->with('error', 'Token pembayaran tidak ditemukan.');
        }
        return view('cart.midtrans', compact('order', 'snapToken'));
    }

    private function syncCartToDatabase($cart)
    {
        $user = Auth::user();
        if ($user) {
            \App\Models\Cart::updateOrCreate(
                ['user_id' => $user->id],
                ['items' => json_encode($cart)]
            );
        }
    }

    public function midtransNotification(Request $request)
    {
        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // Ambil data notifikasi dari Midtrans (support JSON/raw body)
        $data = $request->all();
        if (empty($data) && $request->getContent()) {
            $data = json_decode($request->getContent(), true);
        }
        \Log::info('Midtrans Notification', $data);

        $orderId = $data['order_id'] ?? null;
        $transactionStatus = $data['transaction_status'] ?? null;
        $paymentType = $data['payment_type'] ?? null;
        $fraudStatus = $data['fraud_status'] ?? null;

        if (!$orderId) {
            \Log::error('Midtrans Notification: order_id missing', $data);
            return response()->json(['message' => 'order_id missing'], 200);
        }

        // Cari order berdasarkan order_id di payment_detail atau kolom order_id jika ada
        $order = \App\Models\Order::where('payment_detail', 'like', '%"order_id":"' . $orderId . '"%')->first();
        if (!$order && \Schema::hasColumn('orders', 'order_id')) {
            $order = \App\Models\Order::where('order_id', $orderId)->first();
        }
        if (!$order) {
            \Log::error('Midtrans Notification: Order not found', ['order_id' => $orderId]);
            return response()->json(['message' => 'Order not found'], 200);
        }

        // Update status order sesuai status dari Midtrans
        if ($transactionStatus === 'capture' || $transactionStatus === 'settlement') {
            $order->status = 'done';
        } elseif ($transactionStatus === 'pending') {
            $order->status = 'pending';
        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $order->status = 'canceled';
        }
        $order->save();
        \Log::info('Midtrans Notification: Order updated', ['order_id' => $orderId, 'status' => $order->status]);
        return response()->json(['message' => 'Notification processed'], 200);
    }
}
