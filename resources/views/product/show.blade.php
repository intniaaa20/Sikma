@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
    <div class="max-w-xl mx-auto bg-white rounded shadow p-6 mt-8">
        <h1 class="text-2xl font-bold mb-4">{{ $menu->name }}</h1>
        @if ($menu->image)
            <img src="{{ url('storage/' . $menu->image) }}" alt="{{ $menu->name }}"
                class="w-full h-64 object-cover rounded mb-4">
        @endif
        <div class="mb-2">
            <span class="font-semibold">Deskripsi:</span>
            <p class="text-gray-700">{{ $menu->description ?? '-' }}</p>
        </div>
        <div class="mb-2">
            <span class="font-semibold">Harga:</span>
            <span class="text-orange-600 font-bold">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
        </div>
        <div class="mb-2">
            <span class="font-semibold">Status:</span>
            <span class="{{ $menu->is_available ? 'text-green-600' : 'text-red-600' }} font-bold">
                {{ $menu->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
            </span>
        </div>
        <div class="mb-2">
            <span class="font-semibold">Kategori:</span>
            @if (!empty($menu->categories) && is_array($menu->categories))
                @foreach ($menu->categories as $cat)
                    <span
                        class="inline-block bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded mr-1 mb-1">{{ $cat }}</span>
                @endforeach
            @else
                <span>-</span>
            @endif
        </div>
        <div class="mt-6">
            <a href="{{ route('menu.index') }}" class="text-blue-500 hover:underline">&larr; Kembali ke Daftar Menu</a>
        </div>
    </div>
@endsection
