@extends('layouts.app')

@section('title', 'Detail Menu')

@section('content')
    <div class="max-w-5xl mx-auto bg-white rounded-xl shadow p-8 mt-8 flex flex-col gap-6">
        <div class="flex flex-col md:flex-row gap-8">
            <div class="flex-1 flex flex-col items-center md:items-start">
                <div class="text-3xl font-black mb-4">{{ $menu->code ?? 'S-0001' }}</div>
                @if ($menu->image)
                    <img src="{{ url('storage/' . $menu->image) }}" alt="{{ $menu->name }}"
                        class="w-80 h-80 object-cover rounded-lg mb-4">
                @else
                    <div class="w-80 h-80 flex items-center justify-center bg-gray-100 rounded-lg mb-4 text-gray-400">Tidak
                        ada gambar</div>
                @endif
            </div>
            <div class="flex-[2] grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2 flex flex-col gap-2">
                    <div class="text-3xl font-extrabold mb-2">{{ $menu->name }}</div>
                    <div class="mb-2">
                        <span class="text-lg">Harga</span><br>
                        <span class="text-2xl font-extrabold">Rp{{ number_format($menu->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="mb-2">
                        <span class="text-lg">Estimasi Pemesanan</span><br>
                        <span class="font-bold text-lg">{{ $menu->estimate ?? '3 hari kerja' }}</span>
                    </div>
                    <div class="mb-2">
                        <span class="text-lg font-semibold">Komposisi</span>
                        <div class="text-gray-700">{{ $menu->composition ?? '-' }}</div>
                    </div>
                    <div class="mb-2">
                        <span class="text-lg font-semibold">Deskripsi</span>
                        <div class="text-gray-700">{{ $menu->description ?? '-' }}</div>
                    </div>
                </div>
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="text-lg">Tipe</span><br>
                        <span class="font-extrabold text-2xl">{{ $menu->type ?? 'Paket' }}</span>
                    </div>
                    <div>
                        <span class="text-lg">Bahan Utama</span><br>
                        <span
                            class="font-extrabold text-2xl">{{ $menu->main_ingredient ?? (is_array($menu->categories) && count($menu->categories) ? $menu->categories[0] : '-') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
