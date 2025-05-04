<<<<<<< HEAD
@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Menu Kami</h1>
    <form method="GET" action="" x-data="{ open: false }"
        class="mb-8 flex flex-col sm:flex-row items-center justify-center w-full max-w-lg mx-auto gap-3">
        <div class="relative w-full">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama menu..."
                class="peer w-full border-2 border-yellow-300 focus:border-yellow-500 rounded-full px-5 py-3 pr-12 text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-200 transition placeholder-gray-400" />
            <button type="submit"
                class="absolute right-2 top-1/2 -translate-y-1/2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-full p-2 shadow transition focus:outline-none focus:ring-2 focus:ring-yellow-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                </svg>
            </button>
        </div>
        <div class="relative w-full sm:w-auto" @click.away="open = false">
            <select name="category" onchange="this.form.submit()" @focus="open = true" @blur="open = false"
                @change="open = false"
                class="appearance-none w-full border-2 border-yellow-300 focus:border-yellow-500 rounded-full px-5 py-3 pr-10 text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-200 transition cursor-pointer bg-white font-semibold">
                <option value="" {{ !$selectedCategory ? 'selected' : '' }} class="font-semibold text-yellow-700">🍽️
                    Semua Kategori</option>
                @foreach ($allCategories as $cat)
                    <option value="{{ $cat }}" {{ $selectedCategory == $cat ? 'selected' : '' }}
                        class="font-semibold text-yellow-700">{{ ucfirst($cat) }}</option>
                @endforeach
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-yellow-500 transition-transform duration-200"
                :class="open ? 'rotate-180' : 'rotate-0'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </div>
    </form>
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse ($menus as $menu)
            <div class="bg-white rounded shadow p-4 flex flex-col">
                @if ($menu->image)
                    <img src="{{ url('storage/' . $menu->image) }}" alt="{{ $menu->name }}"
                        class="w-full h-40 object-cover rounded mb-3">
                @else
                    <div class="w-full h-40 flex items-center justify-center bg-gray-100 rounded mb-3 text-gray-400">Tidak
                        ada gambar</div>
                @endif
                <h2 class="font-semibold text-lg mb-1">{{ $menu->name }}</h2>
                <p class="text-gray-600 text-sm mb-2 flex-grow">{{ $menu->description ?? 'Tidak ada deskripsi.' }}</p>
                <div class="flex items-center justify-between mt-auto">
                    <span class="text-primary font-bold">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                    <div class="flex gap-1">
                        <a href="{{ route('menu.show', $menu->id) }}"
                            class="inline-flex items-center justify-center w-8 h-8 rounded bg-yellow-100 hover:bg-yellow-200 text-yellow-700"
                            title="Lihat Detail">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </a>
                        <form action="{{ route('cart.add', ['menu' => $menu->id]) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded">+
                                Tambah</button>
                        </form>
                    </div>
                </div>
                @if (!empty($menu->categories) && is_array($menu->categories) && count($menu->categories) > 0)
                    <div class="mt-2">
                        <span class="inline-block bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded">
                            {{ $menu->categories[0] }}
                        </span>
                    </div>
                @endif
            </div>
        @empty
            <div class="col-span-4 text-center text-gray-500">Belum ada menu yang tersedia saat ini.</div>
        @endforelse
    </div>
@endsection
=======
<x-app-layout>
    {{-- Container sudah ada di app-layout --}}
    <h1 class="h2 mb-4">Menu Kami</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        @forelse ($menus as $menu)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    {{-- Placeholder for image --}}
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                        style="height: 180px;">
                        <span class="text-muted">Image Placeholder</span>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title mb-1">{{ $menu->name }}</h5>
                        <p class="card-text text-muted small mb-2 flex-grow-1">
                            {{ $menu->description ?? 'Tidak ada deskripsi.' }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-bold text-primary fs-5">
                                Rp {{ number_format($menu->price, 0, ',', '.') }}
                            </span>
                        </div>
                        <form action="{{ route('cart.add', $menu) }}" method="POST" class="mt-auto">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">
                                Tambah ke Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center text-muted">Belum ada menu yang tersedia saat ini.</p>
            </div>
        @endforelse
    </div>
</x-app-layout>
>>>>>>> 11bef3afaaf72c1e50919d38cee6d046b0ef42c6
