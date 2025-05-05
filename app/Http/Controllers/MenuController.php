<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the available menu items.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Menu::where('is_available', true);
        $selectedCategory = $request->input('category');
        if ($selectedCategory) {
            $query->whereJsonContains('categories', $selectedCategory);
        }
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%")
                    ->orWhereJsonContains('categories', $search);
            });
        }
        $menus = $query->get();
        // Ambil semua kategori unik dari menu
        $allCategories = Menu::whereNotNull('categories')->pluck('categories')->flatten()->unique()->values();
        return view('menu.index', compact('menus', 'allCategories', 'selectedCategory'));
    }

    /**
     * Display the specified menu item.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\View\View
     */
    public function show(Menu $menu)
    {
        return view('product.show', compact('menu'));
    }
}
