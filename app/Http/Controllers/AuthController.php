<?php

namespace App\Http\Controllers;

use App\Models\User; // Import User model
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Import Hash jika perlu manual (tapi model User sudah handle)
use Illuminate\View\View; // Import View

class AuthController extends Controller
{
    /**
     * Menampilkan form login.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm(): View
    {
        // Pastikan Anda punya view di resources/views/auth/login.blade.php
        return view('auth.login');
    }

    /**
     * Menangani percobaan login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request): RedirectResponse
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Coba autentikasi pengguna
        //    Parameter kedua (true/false) adalah untuk "remember me"
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Jika berhasil:
            // Regenerasi session ID untuk keamanan
            $request->session()->regenerate();

            // Redirect ke halaman yang dituju sebelumnya (jika ada)
            // atau ke halaman default setelah login (misal '/dashboard' atau '/')
            // return redirect()->intended('/'); // Redirect ke halaman utama
            return redirect()->intended('/admin'); // Redirect ke panel admin jika berhasil

        }

        // 3. Jika autentikasi gagal
        // Kembalikan ke halaman login dengan pesan error dan input sebelumnya
        return back()->withErrors([
            'email' => 'Email atau password yang diberikan salah.',
        ])->onlyInput('email'); // Hanya kirim kembali input email (bukan password)
    }

    /**
     * Menampilkan form registrasi.
     *
     * @return \Illuminate\View\View
     */
    public function showRegisterForm(): View
    {
        // Pastikan Anda punya view di resources/views/auth/register.blade.php
        return view('auth.register');
    }

    /**
     * Menangani registrasi pengguna baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request): RedirectResponse
    {
        // 1. Validasi input
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], // 'unique:users' memastikan email belum terdaftar
            'password' => ['required', 'string', 'min:8', 'confirmed'], // 'confirmed' mencari input 'password_confirmation'
        ]);

        // 2. Buat pengguna baru
        // Password akan otomatis di-hash oleh mutator di model User
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
            // 'is_admin' akan default ke false (sesuai migrasi dan model)
        ]);

        // 3. (Opsional) Langsung loginkan pengguna setelah registrasi
        Auth::login($user);

        // 4. Redirect ke halaman setelah registrasi berhasil
        // return redirect('/'); // Redirect ke halaman utama
        return redirect('/login')->with('status', 'Registrasi berhasil! Silakan login.'); // Redirect ke login dengan pesan

    }

    /**
     * Log the user out of the application.
     * (Method ini sudah Anda buat sebelumnya)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('status', 'Anda telah berhasil logout.');
    }
}