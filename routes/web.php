<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; // Pastikan sudah diimport
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Halaman utama - Menggunakan layout 'main'
Route::get('/', function () {
    return view('welcome'); // View ini akan extend layouts.main
})->name('welcome');

// --- Grup Route Autentikasi (Hanya untuk Tamu) ---
Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Register Routes
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
// --- Akhir Grup Tamu ---

// --- Route Logout (Hanya untuk User Login) ---
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
// ---------------------------------------------

// --- (OPSIONAL) Route untuk Panel Admin (jika menggunakan Filament) ---
// Filament biasanya menangani route panelnya sendiri melalui PanelProvider,
// jadi Anda mungkin tidak perlu menambahkan route eksplisit di sini.
// Pastikan middleware CheckIsAdmin ditambahkan di AdminPanelProvider.php

// --- (CONTOH) Route yang Membutuhkan Login (tapi bukan admin) ---
Route::get('/dashboard', function () {
    return view('dashboard'); // View ini akan extend layouts.main
})->middleware('auth')->name('dashboard');
