<?php

use App\Http\Controllers\ProfileController;
<<<<<<< HEAD
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Models\Menu; // Pastikan Model Menu di-import
=======
use Illuminate\Support\Facades\Route;
>>>>>>> 11bef3afaaf72c1e50919d38cee6d046b0ef42c6

Route::get('/', function () {
    return view('welcome');
});

<<<<<<< HEAD
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');

    // Route untuk Halaman Menu Pelanggan (bisa di luar middleware auth jika publik)
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::get('/menu/{menu}', [MenuController::class, 'show'])->name('menu.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

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

    // Tambahkan route lain yang mungkin diperlukan keranjang nanti (misal: cart.show)
    Route::middleware('auth')->group(function () {
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add/{menu}', [CartController::class, 'add'])->name('cart.add');
        Route::post('/cart/update/{menu}', [CartController::class, 'update'])->name('cart.update');
        Route::post('/cart/remove/{menu}', [CartController::class, 'remove'])->name('cart.remove');
        Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    });

});

require __DIR__ . '/auth.php';
=======
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
>>>>>>> 11bef3afaaf72c1e50919d38cee6d046b0ef42c6
