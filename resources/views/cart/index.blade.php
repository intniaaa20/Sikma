@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Keranjang Belanja</h1>
    @if (session('success'))
        {{-- <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div> --}}
    @endif
    @php $hasCart = count($cart); @endphp
    @if ($hasCart)
        <form method="POST" action="{{ route('cart.clear') }}" class="mb-4 flex justify-end">
            @csrf
            <button type="submit"
                class="flex items-center gap-2 bg-gradient-to-r from-red-400 to-red-600 hover:from-red-500 hover:to-red-700 text-white px-6 py-2 rounded-full font-bold shadow-lg transition-all duration-200 text-base focus:outline-none focus:ring-2 focus:ring-red-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Kosongkan Keranjang
            </button>
        </form>
        <form method="POST" action="{{ route('cart.checkout') }}" id="cart-checkout-form" class="relative">
            @csrf
            <div class="overflow-x-auto rounded-lg shadow-lg bg-white p-4">
                <table class="min-w-full divide-y divide-yellow-200">
                    <thead class="bg-gradient-to-r from-yellow-200 to-yellow-400">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-yellow-800 uppercase tracking-wider">
                                <input type="checkbox" id="select-all">
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-yellow-800 uppercase tracking-wider">Menu
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-yellow-800 uppercase tracking-wider">Harga
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-yellow-800 uppercase tracking-wider">
                                Jumlah</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-yellow-800 uppercase tracking-wider">
                                Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-yellow-100">
                        @php $total = 0; @endphp
                        @foreach ($cart as $key => $item)
                            @if (is_numeric($key))
                                @php
                                    $menu = $menus->where('id', $key)->first();
                                    if (!$menu) {
                                        continue;
                                    }
                                    $qty = is_array($item) ? $item['qty'] ?? 1 : $item;
                                    $subtotal = $menu->price * $qty;
                                    $total += $subtotal;
                                @endphp
                                <tr class="hover:bg-yellow-50 transition">
                                    <td class="px-4 py-3 text-center align-middle">
                                        <input type="checkbox" name="selected[]" value="{{ $menu->id }}"
                                            class="item-checkbox rounded border-yellow-400 focus:ring-yellow-500"
                                            data-price="{{ $menu->price }}" data-qty="{{ $qty }}">
                                    </td>
                                    <td class="px-4 py-3 flex items-center gap-3 align-middle">
                                        @if ($menu->image)
                                            <img src="{{ url('storage/' . $menu->image) }}" alt="{{ $menu->name }}"
                                                class="w-14 h-14 object-cover rounded-lg border border-yellow-200 shadow-sm">
                                        @endif
                                        <span class="font-semibold text-gray-800">{{ $menu->name }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-yellow-700 font-bold align-middle">
                                        Rp {{ number_format($menu->price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 align-middle">
                                        <input type="number" name="qty" id="qty-{{ $menu->id }}"
                                            value="{{ $qty }}" min="1"
                                            class="w-20 border-2 border-yellow-300 rounded-lg px-3 py-2 text-center font-semibold qty-input focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500 transition"
                                            data-menu-id="{{ $menu->id }}" />
                                    </td>
                                    <td class="px-4 py-3 font-bold text-yellow-700 align-middle"
                                        id="subtotal-{{ $menu->id }}">Rp {{ number_format($subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @elseif (Str::startsWith($key, 'promo_'))
                                @php
                                    $promoId = (int) Str::after($key, 'promo_');
                                    $promo =
                                        isset($appliedPromo) && $appliedPromo && $appliedPromo->id == $promoId
                                            ? $appliedPromo
                                            : \App\Models\Promo::with('menus')->find($promoId);
                                    $promoMenus = $promo ? $promo->menus : collect();
                                    $bundleLabel = [];
                                    $promoQty = is_array($item) && isset($item['qty']) ? $item['qty'] : 1;
                                    $bundlePrice = 0;
                                    foreach ($promoMenus as $pmenu) {
                                        $bundleLabel[] = $promoQty . 'x ' . $pmenu->name;
                                        $bundlePrice += $pmenu->price;
                                    }
                                    $promoDiscount =
                                        is_array($item) && isset($item['promo_discount'])
                                            ? $item['promo_discount']
                                            : $promo->discount ?? 0;
                                    $bundleSubtotal = max($bundlePrice * $promoQty - $promoDiscount * $promoQty, 0);
                                    $total += $bundleSubtotal;
                                @endphp
                                <tr class="bg-yellow-50">
                                    <td class="px-4 py-3 text-center align-middle">
                                        <input type="checkbox" name="selected[]" value="promo-{{ $promoId }}"
                                            class="item-checkbox rounded border-yellow-400 focus:ring-yellow-500" checked
                                            data-price="{{ $bundleSubtotal }}" data-qty="{{ $promoQty }}">
                                    </td>
                                    <td class="px-4 py-3 align-middle" colspan="1">
                                        <span class="font-bold text-yellow-800">Promo Bundle:
                                            {{ $promo->title ?? 'Promo' }}</span>
                                        <span
                                            class="text-xs text-gray-500 ml-2">({{ implode(' + ', $bundleLabel) }})</span>
                                    </td>
                                    <td class="px-4 py-3 text-yellow-700 font-bold align-middle">-</td>
                                    <td class="px-4 py-3 align-middle text-center font-bold">x {{ $promoQty }}</td>
                                    <td class="px-4 py-3 font-bold text-green-700 align-middle">Rp
                                        {{ number_format($bundleSubtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-yellow-100">
                            <td colspan="4" class="px-4 py-3 text-right font-bold text-lg text-yellow-800">Total</td>
                            <td class="px-4 py-3 font-extrabold text-yellow-900 text-lg" id="cart-total">Rp
                                {{ number_format($total, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <button type="submit" id="checkout-btn" disabled
                class="fixed bottom-8 right-8 z-40 bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-white px-8 py-4 rounded-full shadow-lg text-lg font-bold flex items-center gap-2 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 9V7a5 5 0 00-10 0v2M5 9h14l1 12H4L5 9zm2 4h10" />
                </svg>
                Checkout
            </button>
            <button type="button" id="delete-selected-btn" disabled
                class="fixed bottom-8 right-56 z-40 bg-gradient-to-r from-red-400 to-red-600 hover:from-red-500 hover:to-red-700 text-white px-5 py-3 rounded-full shadow-lg text-base font-bold flex items-center gap-2 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                title="Hapus yang dipilih">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </form>
        <form id="delete-selected-form" method="POST" action="{{ route('cart.deleteSelected') }}" style="display:none;">
            @csrf
            <input type="hidden" name="selected" id="delete-selected-input">
        </form>
        <script>
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.item-checkbox');
            const checkoutBtn = document.getElementById('checkout-btn');
            const deleteBtn = document.getElementById('delete-selected-btn');

            function updateActionBtns() {
                const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                checkoutBtn.disabled = !anyChecked;
                deleteBtn.disabled = !anyChecked;
            }
            selectAll.addEventListener('change', function() {
                checkboxes.forEach(cb => cb.checked = this.checked);
                updateActionBtns();
            });
            checkboxes.forEach(cb => cb.addEventListener('change', updateActionBtns));
            updateActionBtns();
            deleteBtn.addEventListener('click', function() {
                const selected = Array.from(checkboxes).filter(cb => cb.checked).map(cb => cb.value);
                document.getElementById('delete-selected-input').value = selected.join(',');
                document.getElementById('delete-selected-form').submit();
            });

            function updateCartQty(menuId, reloadAfter = false) {
                const qty = document.getElementById('qty-' + menuId).value;
                fetch(`/cart/update/${menuId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `qty=${qty}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const subtotalCell = document.querySelector(`#subtotal-${menuId}`);
                            if (subtotalCell) {
                                subtotalCell.textContent = data.subtotal;
                            }
                            document.getElementById('cart-total').textContent = data.total;
                            if (reloadAfter) {
                                location.reload();
                            }
                        }
                    });
            }

            const updateForms = document.querySelectorAll('.single-update-form');
            updateForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const menuId = this.action.split('/').pop();
                    updateCartQty(menuId);
                });
            });

            // Hapus event submit form, ganti dengan event onchange pada input qty
            const qtyInputs = document.querySelectorAll('.qty-input');
            qtyInputs.forEach(input => {
                input.addEventListener('change', function() {
                    const menuId = this.dataset.menuId;
                    updateCartQty(menuId);
                });
                input.addEventListener('change', function() {
                    location.reload();
                });
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const menuId = this.dataset.menuId;
                        updateCartQty(menuId, true); // true = reload after update
                    }
                });
            });

            // Hapus polling interval, update hanya saat qty berubah
        </script>
    @else
        <div class="text-center text-gray-500">Keranjang belanja kosong.</div>
    @endif
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateCartTotal() {
                let total = 0;
                document.querySelectorAll('.item-checkbox').forEach(cb => {
                    const qtyInput = document.getElementById('qty-' + cb.value);
                    let qty = qtyInput ? parseInt(qtyInput.value) : 1;
                    if (isNaN(qty) || qty < 1) qty = 1;
                    const price = parseInt(cb.getAttribute('data-price'));
                    if (cb.checked) {
                        total += price * qty;
                    }
                });
                document.getElementById('cart-total').textContent = 'Rp ' + total.toLocaleString('id-ID');
            }

            document.querySelectorAll('.item-checkbox').forEach(cb => {
                cb.addEventListener('change', updateCartTotal);
            });
            document.querySelectorAll('.qty-input').forEach(input => {
                input.addEventListener('change', updateCartTotal);
                input.addEventListener('input', updateCartTotal);
            });
            updateCartTotal();
        });
    </script>
    <style>
        @media (max-width: 640px) {

            table.min-w-full th,
            table.min-w-full td {
                padding: 0.5rem 0.25rem;
                font-size: 0.85rem;
            }

            .w-14,
            .h-14 {
                width: 2.5rem !important;
                height: 2.5rem !important;
            }

            .w-20 {
                width: 3.5rem !important;
            }
        }
    </style>
@endsection
