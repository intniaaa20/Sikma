<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth Facade
use Symfony\Component\HttpFoundation\Response;

class CheckIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan pengguna sudah login (meskipun Filament biasanya sudah menanganinya)
        // dan periksa apakah dia BUKAN admin.
        if (Auth::check() && !Auth::user()->is_admin) {
            // Jika bukan admin, arahkan ke halaman utama
            // Ganti '/' dengan nama route jika Anda punya route bernama 'welcome' atau 'home'
            // Contoh: return redirect()->route('welcome')->with(...);
            return redirect('/')->with('warning', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        // Jika pengguna adalah admin (atau tidak login, yang akan ditangani auth lain),
        // lanjutkan ke permintaan berikutnya.
        return $next($request);
    }
}