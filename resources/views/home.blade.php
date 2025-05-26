@extends('layouts.app')

@section('content')
    @if (isset($promotions) && $promotions->count())
        <h1 class="text-xl font-bold mb-6">Promo Spesial</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
            @foreach ($promotions as $promo)
                <div
                    class="bg-white rounded-2xl shadow-xl p-8 flex flex-col transition-all duration-200 cursor-pointer hover:shadow-2xl hover:scale-[1.04] hover:bg-yellow-50 hover:border-yellow-300 border border-transparent group min-h-[320px] md:min-h-[340px] w-full">
                    @if ($promo->poster_path)
                        <img src="{{ url('storage/' . $promo->poster_path) }}" alt="{{ $promo->title }}"
                            class="w-full h-64 md:h-80 object-cover rounded-xl mb-5 group-hover:opacity-80 transition shadow-lg border border-yellow-100">
                    @else
                        <div
                            class="w-full h-64 md:h-80 flex items-center justify-center bg-gray-100 rounded-xl mb-5 text-gray-400 text-2xl shadow-lg border border-yellow-100">
                            Tidak ada gambar
                        </div>
                    @endif
                    <h2 class="font-semibold text-lg mb-1 group-hover:text-yellow-600 transition">{{ $promo->title }}</h2>
                    <div class="text-gray-700 mb-2">{{ $promo->description ?? '-' }}</div>
                    @if ($promo->menus && $promo->menus->count())
                        <div class="mb-2">
                            <span class="text-xs text-gray-500">Menu Promo:</span>
                            <ul class="list-disc pl-4">
                                @php
                                    // Contoh: Esteh (qty 2) + Ayam Ganja (qty 1)
                                    $items = [
                                        [
                                            'name' => 'Ayam Ganja',
                                            'qty' => 1,
                                            'price' => null,
                                        ],
                                        [
                                            'name' => 'Es Teh',
                                            'qty' => 1,
                                            'price' => null,
                                        ],
                                    ];
                                    // Ambil harga dari relasi menu promo
                                    foreach ($promo->menus as $menu) {
                                        foreach ($items as &$item) {
                                            if (strtolower($menu->name) === strtolower($item['name'])) {
                                                $item['price'] = $menu->price;
                                            }
                                        }
                                    }
                                    unset($item);
                                    $total = 0;
                                    $label = [];
                                    foreach ($items as $item) {
                                        if ($item['price'] !== null) {
                                            $total += $item['price'] * $item['qty'];
                                            $label[] = $item['qty'] . 'x ' . $item['name'];
                                        }
                                    }
                                    $final = max($total - $promo->discount, 0);
                                @endphp
                                <li class="text-xs text-yellow-700 font-semibold flex flex-col gap-1">
                                    <span>{{ implode(' + ', $label) }}</span>
                                    @if ($promo->discount > 0 && $total > 0)
                                        <span class="text-xs text-gray-500">(Rp
                                            {{ isset($items[0]['price']) && $items[0]['price'] !== null ? number_format($items[0]['price'], 0, ',', '.') : '0' }}
                                            + Rp
                                            {{ isset($items[1]['price']) && $items[1]['price'] !== null ? number_format($items[1]['price'], 0, ',', '.') : '0' }}
                                            ) - Diskon: Rp {{ number_format($promo->discount, 0, ',', '.') }}</span>
                                        <span class="text-green-700 font-bold text-sm">= Rp
                                            {{ number_format($final, 0, ',', '.') }}</span>
                                    @elseif ($total > 0)
                                        <span class="text-yellow-700 font-bold text-sm">Rp
                                            {{ number_format($total, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-gray-400 italic">Menu tidak ditemukan di promo</span>
                                    @endif
                                </li>
                            </ul>
                            <div class="mt-3">
                                <button
                                    class="btn-promo-cart bg-gradient-to-br from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-bold px-5 py-2 rounded-lg shadow-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm"
                                    data-menu-ids="{{ implode(',', $promo->menus->pluck('id')->toArray()) }}"
                                    data-promo-id="{{ $promo->id }}" data-promo-discount="{{ $promo->discount }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                    </svg>
                                </button>
                            </div>
                            </ul>
                        </div>
                    @endif
                    <div class="text-xs text-gray-400 mt-auto">Periode: {{ date('d M Y', strtotime($promo->start_date)) }}
                        -
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

            // Promo: Tambah ke Keranjang Promo (bundle)
            document.querySelectorAll('.btn-promo-cart').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const menuIds = this.dataset.menuIds.split(',');
                    const promoId = this.dataset.promoId;
                    const promoDiscount = this.dataset.promoDiscount;
                    let added = 0;
                    let failed = 0;
                    let done = 0;
                    menuIds.forEach(menuId => {
                        fetch(`/cart/add/${menuId}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({
                                    promo_id: promoId,
                                    promo_discount: promoDiscount
                                })
                            })
                            .then(res => {
                                done++;
                                if (res.ok) {
                                    added++;
                                } else {
                                    failed++;
                                }
                                if (done === menuIds.length) {
                                    if (added > 0) {
                                        alert(
                                            'Menu promo berhasil ditambahkan ke keranjang!'
                                            );
                                        location.reload();
                                    } else {
                                        alert(
                                            'Gagal menambah menu promo ke keranjang.'
                                            );
                                    }
                                }
                            });
                    });
                });
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
