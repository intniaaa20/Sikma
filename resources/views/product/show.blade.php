@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
    <div class="max-w-xl mx-auto bg-white rounded-2xl shadow-2xl p-6 mt-8 border border-yellow-100 animate-fade-in">
        <div class="flex flex-col sm:flex-row gap-6 items-center mb-4">
            @if ($menu->image)
                <img src="{{ url('storage/' . $menu->image) }}" alt="{{ $menu->name }}"
                    class="w-64 h-64 object-cover rounded-xl border-2 border-yellow-200 shadow-md transition-transform duration-300 hover:scale-105">
            @else
                <div class="w-64 h-64 flex items-center justify-center bg-yellow-50 rounded-xl text-yellow-400 text-6xl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-20 h-20">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"
                            fill="#fff" />
                    </svg>
                </div>
            @endif
            <div class="flex-1">
                <h1 class="text-3xl font-extrabold text-yellow-700 mb-2">{{ $menu->name }}</h1>
                <div class="mb-2 flex items-center gap-2">
                    <span class="font-semibold">Harga:</span>
                    <span class="text-orange-600 font-bold text-xl">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                </div>
                <div class="mb-2 flex items-center gap-2">
                    <span class="font-semibold">Status:</span>
                    <span
                        class="{{ $menu->is_available ? 'text-green-600' : 'text-red-600' }} font-bold flex items-center gap-1">
                        <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"
                                fill="{{ $menu->is_available ? '#bbf7d0' : '#fecaca' }}" />
                        </svg>
                        {{ $menu->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
                    </span>
                </div>
                <div class="mb-2 flex items-center gap-2 flex-wrap">
                    <span class="font-semibold">Kategori:</span>
                    @if (!empty($menu->categories) && is_array($menu->categories))
                        @foreach ($menu->categories as $cat)
                            <span
                                class="inline-block bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full mr-1 mb-1 shadow">{{ $cat }}</span>
                        @endforeach
                    @else
                        <span>-</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="mb-4">
            <span class="font-semibold block mb-1">Deskripsi:</span>
            @php
                use Illuminate\Support\Str;
                $desc = $menu->description ?? 'Tidak ada deskripsi.';
                if (Str::contains($desc, ['<ul', '<ol', '<li'])) {
                    $descHtml = $desc;
                } else {
                    $descHtml = preg_replace('/^\s*([\*-])\s+(.*)$/m', '<li>$2</li>', e($desc));
                    if (Str::contains($descHtml, '<li>')) {
                        $descHtml = '<ul class="list-disc pl-6">' . $descHtml . '</ul>';
                    } else {
                        $descHtml = nl2br($descHtml);
                    }
                }
            @endphp
            <p class="text-gray-700 bg-yellow-50 rounded-lg p-3 shadow-inner min-h-[48px]">{!! $descHtml !!}</p>
        </div>
        <div class="mt-8 flex flex-col sm:flex-row justify-between items-center gap-4">
            <a href="{{ route('menu.index') }}" class="text-blue-500 hover:underline flex items-center gap-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Daftar Menu
            </a>
            @if ($menu->is_available && (!auth()->user() || !auth()->user()->hasRole('admin')))
                <form method="POST" action="{{ route('cart.add', $menu->id) }}" class="flex items-center gap-2">
                    @csrf
                    <button type="submit"
                        class="bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-white px-6 py-2 rounded-full shadow-lg text-base font-bold flex items-center gap-2 transition-all duration-200 focus:ring-2 focus:ring-yellow-400 focus:outline-none active:scale-95">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah ke Keranjang
                    </button>
                </form>
            @endif
        </div>
    </div>
    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        .animate-fade-in {
            animation: fade-in 0.7s cubic-bezier(.4, 2, .6, 1) both;
        }

        @media (max-width: 640px) {
            .max-w-xl {
                max-width: 100% !important;
            }

            .p-6 {
                padding: 1rem !important;
            }

            .rounded-2xl,
            .rounded-xl {
                border-radius: 1rem !important;
            }

            .w-64,
            .h-64 {
                width: 10rem !important;
                height: 10rem !important;
            }

            .text-3xl {
                font-size: 1.3rem !important;
            }

            .text-xl {
                font-size: 1.1rem !important;
            }
        }
    </style>
@endsection
