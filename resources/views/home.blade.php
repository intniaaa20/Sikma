@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Menu Kami</h1>
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
                    <form action="{{ route('cart.add', ['menu' => $menu->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded">+
                            Tambah</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-4 text-center text-gray-500">Belum ada menu yang tersedia saat ini.</div>
        @endforelse
    </div>
@endsection
