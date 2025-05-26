<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'menu_id' => 'required|exists:menus,id',
            'rating' => 'required|integer|min:1|max:10',
            'comment' => 'nullable|string|max:255',
        ]);

        // Cegah duplikasi review untuk kombinasi order_id + menu_id
        $existing = Review::where('order_id', $request->order_id)
            ->where('menu_id', $request->menu_id)
            ->first();
        if ($existing) {
            return back()->with('error', 'Anda sudah memberikan review untuk menu ini.');
        }

        Review::create([
            'order_id' => $request->order_id,
            'menu_id' => $request->menu_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'pending', // Atau langsung 'approved' jika tidak perlu moderasi
        ]);

        return back()->with('success', 'Review berhasil dikirim!');
    }
}
