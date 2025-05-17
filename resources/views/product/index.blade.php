@extends('layouts.app')

@section('title', 'Product')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Daftar Produk</h1>
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse ($menus as $menu)
            <a href="{{ route('menu.show', $menu->id) }}"
                class="block bg-white rounded shadow p-4 flex flex-col hover:shadow-lg transition group hover:scale-[1.03] hover:bg-yellow-50 hover:border-yellow-300 border border-transparent duration-200 cursor-pointer">
                @if ($menu->image)
                    <img src="{{ url('storage/' . $menu->image) }}" alt="{{ $menu->name }}"
                        class="w-full h-40 object-cover rounded mb-3 group-hover:opacity-80 transition">
                @else
                    <div class="w-full h-40 flex items-center justify-center bg-gray-100 rounded mb-3 text-gray-400">Tidak
                        ada gambar</div>
                @endif
                <h2 class="font-semibold text-lg mb-1 group-hover:text-yellow-600 transition">{{ $menu->name }}</h2>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-2 shadow-sm min-h-[60px] overflow-hidden transition-all duration-400"
                    id="desc-{{ $menu->id }}">
                    @php
                        $desc = $menu->description ?? 'Tidak ada deskripsi.';
                    @endphp
                    @if (Str::contains($desc, ['<ul', '<ol', '<li']))
                        {!! $desc !!}
                    @else
                        {{ $desc }}
                    @endif
                </div>
                @if ($menu->description && strlen($menu->description) > 80)
                    <button type="button" class="text-yellow-600 hover:underline text-xs font-semibold mt-1"
                        onclick="toggleDesc({{ $menu->id }})" id="btn-desc-{{ $menu->id }}">Show more</button>
                @endif
                <div class="flex items-center justify-between mt-auto gap-2">
                    <span class="text-primary font-bold">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                    <div class="flex gap-1">
                        <a href="{{ route('menu.show', $menu->id) }}" onclick="event.stopPropagation();"
                            class="inline-flex items-center justify-center w-8 h-8 rounded bg-yellow-100 hover:bg-yellow-200 text-yellow-700"
                            title="Lihat Detail">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </a>
                        @if (!auth()->user() || !auth()->user()->hasRole('admin'))
                            <form action="{{ route('cart.add', ['menu' => $menu->id]) }}" method="POST"
                                onclick="event.stopPropagation();">
                                @csrf
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded">+
                                    Tambah</button>
                            </form>
                        @endif
                    </div>
                </div>
                @if (!empty($menu->categories) && is_array($menu->categories) && count($menu->categories) > 0)
                    <div class="mt-2">
                        <span class="inline-block bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded">
                            {{ $menu->categories[0] }}
                        </span>
                    </div>
                @endif
            </a>
        @empty
            <div class="col-span-4 text-center text-gray-500">Belum ada produk yang tersedia saat ini.</div>
        @endforelse
    </div>
    <style>
        .sidebar-anim-hover {
            transition: background 0.22s, color 0.18s, transform 0.18s;
        }

        .sidebar-anim-hover:hover {
            background: #fef08a !important;
            color: #d97706 !important;
            transform: scale(1.04) translateX(4px);
            box-shadow: 0 2px 12px 0 #fde04733;
            font-weight: bold;
        }

        .group:hover .group-hover\:text-yellow-600 {
            color: #ca8a04 !important;
        }

        .group:hover .group-hover\:opacity-80 {
            opacity: 0.8 !important;
        }

        .group:hover .group-hover\:scale-110 {
            transform: scale(1.10) !important;
        }

        .group:hover .group-hover\:bg-yellow-200 {
            background-color: #fef08a !important;
        }
    </style>
@endsection

@section('scripts')
    <script>
        function toggleDesc(id) {
            const desc = document.getElementById('desc-' + id);
            const btn = document.getElementById('btn-desc-' + id);
            if (!desc.style.maxHeight || desc.style.maxHeight === '60px') {
                desc.style.maxHeight = desc.scrollHeight + 'px';
                desc.style.overflow = 'visible';
                btn.textContent = 'Show less';
            } else {
                desc.style.maxHeight = '60px';
                desc.style.overflow = 'hidden';
                btn.textContent = 'Show more';
            }
        }
        // Inisialisasi maxHeight agar animasi smooth
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[id^="desc-"]').forEach(function(desc) {
                desc.style.maxHeight = '60px';
                desc.style.overflow = 'hidden';
            });
        });
    </script>
@endsection
