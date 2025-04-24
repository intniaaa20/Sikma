<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Menampilkan form login customer.
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Menangani percobaan login customer.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // TODO: Tambahkan logika untuk membedakan customer (misal cek role atau is_admin=false)
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('home')); // Redirect ke home setelah login customer
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Menampilkan form login admin.
     */
    public function showAdminLoginForm(): View
    {
        return view('auth.admin-login');
    }

    /**
     * Menangani percobaan login admin.
     */
    public function adminLogin(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // TODO: Tambahkan logika untuk memastikan hanya admin yang bisa login (misal cek role atau is_admin=true)
        // Contoh sederhana: (asumsikan ada kolom 'is_admin' di tabel users)
        // if (Auth::attempt($credentials + ['is_admin' => true], $request->boolean('remember'))) {

        if (Auth::attempt($credentials, $request->boolean('remember'))) { // Ganti ini dengan pengecekan admin
            // Cek apakah user adalah admin setelah login berhasil
            // if ($request->user()->is_admin) { // Contoh
            $request->session()->regenerate();
            // Redirect ke dashboard admin (sesuaikan route jika perlu)
            return redirect()->intended('/admin');
            // }
            // Jika bukan admin, logout lagi
            // Auth::logout();
            // $request->session()->invalidate();
            // $request->session()->regenerateToken();
            // return back()->with('status', 'Akses ditolak. Akun ini bukan admin.')->onlyInput('email');
        }

        return back()->with('status', 'Email atau password salah.')->onlyInput('email');
    }

    /**
     * Melakukan logout user.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
