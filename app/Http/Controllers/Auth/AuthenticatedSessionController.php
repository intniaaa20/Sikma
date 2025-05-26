<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        // Restore cart from database to session after login
        $user = Auth::user();
        $cart = \App\Models\Cart::where('user_id', $user->id)->first();
        if ($cart) {
            session(['cart' => $cart->items]);
        }

        return redirect()->intended('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Simpan cart ke database sebelum logout
        if (Auth::check()) {
            $user = Auth::user();
            $cart = session('cart', []);
            \App\Models\Cart::updateOrCreate(
                ['user_id' => $user->id],
                ['items' => $cart]
            );
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
