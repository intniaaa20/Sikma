<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Menu Makanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($menus->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach ($menus as $menu)
                                <div
                                    class="border rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300">
                                    {{-- Jika Anda punya kolom gambar, tampilkan di sini --}}
                                    {{-- <img src="{{ asset('path/ke/gambar/' . $menu->image_filename) }}" alt="{{ $menu->name }}" class="w-full h-48 object-cover"> --}}
                                    <div class="p-4">
                                        <h3 class="text-lg font-semibold mb-2">{{ $menu->name }}</h3>
                                        <p class="text-gray-600 text-sm mb-3">
                                            {{ $menu->description ?? 'Tidak ada deskripsi.' }}
                                        </p>
                                        <div class="flex justify-between items-center">
                                            <span class="text-lg font-bold text-orange-600">
                                                Rp {{ number_format($menu->price, 0, ',', '.') }}
                                            </span>
                                            {{-- Tambahkan tombol "Pesan" atau "Detail" jika perlu --}}
                                            {{-- <button class="px-3 py-1 bg-orange-500 text-white text-sm rounded hover:bg-orange-600">Pesan</button> --}}
                                        </div>
                                        @if (!empty($menu->categories) && is_array($menu->categories) && count($menu->categories) > 0)
                                            <div class="mt-2">
                                                <span
                                                    class="inline-block bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded">{{ $menu->categories[0] }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-gray-500">Saat ini belum ada menu yang tersedia.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
