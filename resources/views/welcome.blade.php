@extends('layouts.app')

@section('content')
    @if (isset($promotions) && $promotions->count())
        <h1 class="text-xl font-bold mb-6">Promo Spesial</h1>
        <div class="grid grid-cols-3 grid-rows-2 gap-6 mb-10">
            @foreach ($promotions as $promo)
                <div
                    class="bg-white rounded shadow p-4 flex flex-col transition-all duration-200 cursor-pointer hover:shadow-lg hover:scale-[1.03] hover:bg-yellow-50 hover:border-yellow-300 border border-transparent group">
                    @if ($promo->poster_path)
                        <img src="{{ url('storage/' . $promo->poster_path) }}" alt="{{ $promo->title }}"
                            class="w-full h-40 object-cover rounded mb-3 group-hover:opacity-80 transition">
                    @else
                        <div class="w-full h-40 flex items-center justify-center bg-gray-100 rounded mb-3 text-gray-400">
                            Tidak ada gambar</div>
                    @endif
                    <h2 class="font-semibold text-lg mb-1 group-hover:text-yellow-600 transition">{{ $promo->title }}</h2>
                    <div class="text-gray-700 mb-2">{{ $promo->description ?? '-' }}</div>
                    @if ($promo->menus && $promo->menus->count())
                        <div class="mb-2">
                            <span class="text-xs text-gray-500">Menu Promo:</span>
                            <ul class="list-disc pl-4">
                                @foreach ($promo->menus as $menu)
                                    <li class="text-xs text-yellow-700 font-semibold">{{ $menu->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="text-xs text-gray-400 mt-auto">Periode: {{ date('d M Y', strtotime($promo->start_date)) }} -
                        {{ date('d M Y', strtotime($promo->end_date)) }}</div>
                </div>
            @endforeach
        </div>
    @endif

    <h1 class="text-xl font-bold mb-6">Menu Hari Ini</h1>
    @if (isset($menusToday) && $menusToday->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-10">
            @foreach ($menusToday as $menu)
                <div
                    class="bg-white rounded shadow p-4 flex flex-col transition-all duration-200 cursor-pointer hover:shadow-lg hover:scale-[1.03] hover:bg-yellow-50 hover:border-yellow-300 border border-transparent group">
                    @if ($menu->image)
                        <img src="{{ url('storage/' . $menu->image) }}" alt="{{ $menu->name }}"
                            class="w-full h-40 object-cover rounded mb-3 group-hover:opacity-80 transition">
                    @else
                        <div class="w-full h-40 flex items-center justify-center bg-gray-100 rounded mb-3 text-gray-400">
                            Tidak ada gambar</div>
                    @endif
                    <h2 class="font-semibold text-lg mb-1 group-hover:text-yellow-600 transition">{{ $menu->name }}</h2>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-2 shadow-sm min-h-[60px] overflow-hidden transition-all duration-400"
                        id="desc-{{ $menu->id }}">
                        {!! nl2br(e($menu->description ?? 'Tidak ada deskripsi.')) !!}
                    </div>
                    @if ($menu->description && strlen($menu->description) > 80)
                        <button type="button" class="text-yellow-600 hover:underline text-xs font-semibold mt-1"
                            onclick="toggleDesc({{ $menu->id }})" id="btn-desc-{{ $menu->id }}">Show more</button>
                    @endif
                    <div class="flex items-center justify-between mt-auto">
                        <span class="text-primary font-bold">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                        <div class="flex gap-2">
                            <a href="{{ route('menu.show', $menu->id) }}"
                                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-br from-yellow-300 to-yellow-500 hover:from-yellow-400 hover:to-yellow-600 text-yellow-900 shadow-lg border-2 border-yellow-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-yellow-400 group"
                                title="Lihat Detail">
                                <span class="sr-only">Lihat Detail</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor"
                                    class="w-6 h-6 group-hover:scale-110 group-hover:text-orange-600 transition-transform duration-200">
                                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"
                                        fill="#fff" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </a>
                            @if (!auth()->user() || !auth()->user()->hasRole('admin'))
                                <form action="{{ route('cart.add', ['menu' => $menu->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 hover:from-blue-500 hover:to-blue-700 text-white shadow-lg border-2 border-blue-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400 text-xl font-bold transform hover:scale-110 hover:rotate-6"
                                        title="Tambah Ke menu">+</button>
                                </form>
                            @endif
                        </div>
                    </div>
                    @if (!empty($menu->categories) && is_array($menu->categories) && count($menu->categories) > 0)
                        <div class="mt-2">
                            <span
                                class="inline-block bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded">{{ $menu->categories[0] }}</span>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div class="text-gray-500 mb-10">Belum ada menu hari ini.</div>
    @endif

    <h1 class="text-xl font-bold mb-6">Menu Favorit</h1>
    @if (isset($favoriteMenus) && $favoriteMenus->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($favoriteMenus as $menu)
                <div
                    class="bg-white rounded shadow p-4 flex flex-col transition-all duration-200 cursor-pointer hover:shadow-lg hover:scale-[1.03] hover:bg-yellow-50 hover:border-yellow-300 border border-transparent group">
                    @if ($menu->image)
                        <img src="{{ url('storage/' . $menu->image) }}" alt="{{ $menu->name }}"
                            class="w-full h-40 object-cover rounded mb-3 group-hover:opacity-80 transition">
                    @else
                        <div class="w-full h-40 flex items-center justify-center bg-gray-100 rounded mb-3 text-gray-400">
                            Tidak ada gambar</div>
                    @endif
                    <h2 class="font-semibold text-lg mb-1 group-hover:text-yellow-600 transition">{{ $menu->name }}</h2>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-2 shadow-sm min-h-[60px] overflow-hidden transition-all duration-400"
                        id="desc-{{ $menu->id }}">
                        {!! nl2br(e($menu->description ?? 'Tidak ada deskripsi.')) !!}
                    </div>
                    @if ($menu->description && strlen($menu->description) > 80)
                        <button type="button" class="text-yellow-600 hover:underline text-xs font-semibold mt-1"
                            onclick="toggleDesc({{ $menu->id }})" id="btn-desc-{{ $menu->id }}">Show more</button>
                    @endif
                    <div class="flex items-center justify-between mt-auto">
                        <span class="text-primary font-bold">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                        <div class="flex gap-2">
                            <a href="{{ route('menu.show', $menu->id) }}"
                                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-br from-yellow-300 to-yellow-500 hover:from-yellow-400 hover:to-yellow-600 text-yellow-900 shadow-lg border-2 border-yellow-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-yellow-400 group"
                                title="Lihat Detail">
                                <span class="sr-only">Lihat Detail</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor"
                                    class="w-6 h-6 group-hover:scale-110 group-hover:text-orange-600 transition-transform duration-200">
                                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"
                                        fill="#fff" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </a>
                            @if (!auth()->user() || !auth()->user()->hasRole('admin'))
                                <form action="{{ route('cart.add', ['menu' => $menu->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 hover:from-blue-500 hover:to-blue-700 text-white shadow-lg border-2 border-blue-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400 text-xl font-bold transform hover:scale-110 hover:rotate-6"
                                        title="Tambah Ke menu">+</button>
                                </form>
                            @endif
                        </div>
                    </div>
                    @if (!empty($menu->categories) && is_array($menu->categories) && count($menu->categories) > 0)
                        <div class="mt-2">
                            <span
                                class="inline-block bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded">{{ $menu->categories[0] }}</span>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div class="text-gray-500">Belum ada data menu favorit.</div>
    @endif
@section('scripts')
    <script>
        function toggleDesc(id) {
            document.querySelectorAll('[id^="desc-"]').forEach(function(desc) {
                if (desc.id === 'desc-' + id) {
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
                } else {
                    desc.style.maxHeight = '60px';
                    desc.style.overflow = 'hidden';
                    const otherId = desc.id.replace('desc-', '');
                    const otherBtn = document.getElementById('btn-desc-' + otherId);
                    if (otherBtn) otherBtn.textContent = 'Show more';
                }
            });
        }
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[id^="desc-"]').forEach(function(desc) {
                desc.style.maxHeight = '60px';
                desc.style.overflow = 'hidden';
            });
        });
    </script>
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
    </style>
@endsection
@endsection
