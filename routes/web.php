<?php

use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Models\Menu; // Pastikan Model Menu di-import
use Spatie\Permission\Middlewares\RoleMiddleware as SpatieRoleMiddleware;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Middleware\CheckAdminRole;

Route::get('/', [HomeController::class, 'index']);

// Route untuk menerima notifikasi dari Midtrans (webhook), tidak perlu auth
Route::post('/midtrans/notification', [CartController::class, 'midtransNotification']);



Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user() && auth()->user()->hasRole('admin')) {
            return redirect('/');
        }
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');

    // Route untuk melihat halaman order
    Route::get('/order', [CartController::class, 'orderList'])->name('order.index');

    // Route untuk Halaman Menu Pelanggan (bisa di luar middleware auth jika publik)
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::get('/menu/{menu}', [MenuController::class, 'show'])->name('menu.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('checkout.index');

    // Hapus route GET /cart dan PATCH /cart/update jika CartController tidak digunakan lagi
    // Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    // Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');

    // Tambahkan kembali route POST cart.add
    Route::post('/cart/add/{menu}', function (Menu $menu) {
        if (!$menu->is_available) { // Cek ketersediaan
            return back()->with('error', 'Menu tidak tersedia.');
        }
        // Logika keranjang (session) akan ditambahkan di sini
        // Untuk sekarang, redirect saja
        return back()->with('success', $menu->name . ' ditambahkan ke keranjang (implementasi menyusul).');
    })->name('cart.add');

    // Route untuk menyimpan review makanan dari histori order
    Route::post('/review/store', [ReviewController::class, 'store'])->name('review.store');

    // Tambahkan route lain yang mungkin diperlukan keranjang nanti (misal: cart.show)
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{menu}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{menu}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{menu}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/checkout/process', [CartController::class, 'processCheckout'])->name('checkout.process');
    Route::post('/cart/delete-selected', [CartController::class, 'deleteSelected'])->name('cart.deleteSelected');
    Route::get('/checkout/midtrans/{order}', [CartController::class, 'showMidtransPayment'])->name('checkout.midtrans');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/history', [OrderController::class, 'history'])->name('orders.history');

    Route::get('/messages', [\App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages', [\App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');
});


// Ganti middleware admin dengan pengecekan manual di controller jika 'role' tidak tersedia
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/order-history', [OrderController::class, 'adminOrderHistory'])->name('admin.order-history');
});

Route::post('/cart/add-promo/{promo}', [CartController::class, 'addPromo'])->name('cart.addPromo');

require __DIR__ . '/auth.php';
