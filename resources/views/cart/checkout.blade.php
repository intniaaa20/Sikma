@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Checkout</h1>
    @if (isset($snapToken) && $snapToken)
        <div
            class="max-w-2xl mx-auto bg-white rounded-2xl shadow-2xl p-6 flex flex-col gap-8 border border-yellow-100 animate-fade-in">
            <h2 class="text-xl font-bold mb-2 text-yellow-700">Pembayaran Midtrans</h2>
            <div class="mb-2">
                <strong>ID Pesanan:</strong> {{ $order->id ?? '-' }}<br>
                <strong>Total:</strong> Rp {{ number_format($order->total ?? 0, 0, ',', '.') }}
            </div>
            <div id="midtrans-snap"></div>
            <div class="mt-6 flex flex-col gap-2 items-center">
                <button onclick="window.location.reload()"
                    class="px-6 py-2 bg-yellow-400 hover:bg-yellow-500 text-white rounded shadow font-bold">Cek Status
                    Pembayaran</button>
                <a href="{{ route('orders.index') }}"
                    class="px-6 py-2 bg-yellow-500 text-white rounded shadow font-bold">Lihat Daftar Pesanan</a>
                <div class="text-sm text-gray-500 mt-2 text-center">Jika pembayaran sudah selesai, klik <b>Cek Status
                        Pembayaran</b> untuk memperbarui status. Atau cek di halaman Daftar Pesanan.</div>
            </div>
        </div>
    @else
        <form method="POST" action="{{ route('checkout.process') }}"
            class="max-w-2xl mx-auto bg-white rounded-2xl shadow-2xl p-6 flex flex-col gap-8 border border-yellow-100 animate-fade-in">
            @csrf
            <div>
                <h2 class="font-bold text-xl mb-2 text-yellow-700 flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-yellow-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-house-fill" viewBox="0 0 16 16">
                            <path
                                d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z" />
                            <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293z" />
                        </svg>
                    </span>
                    Alamat Pengantaran
                </h2>
                <input type="text" name="address" value="{{ old('address', $address) }}"
                    placeholder="Masukkan alamat pengantaran"
                    class="w-full border-2 border-yellow-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-gray-700 font-semibold shadow-sm"
                    required>
            </div>
            <div>
                <h2 class="font-bold text-xl mb-2 text-yellow-700 flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-yellow-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-calendar2-date-fill" viewBox="0 0 16 16">
                            <path
                                d="M9.402 10.246c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2" />
                            <path
                                d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5m9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5m-4.118 9.79c1.258 0 2-1.067 2-2.872 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82h-.684c.047.64.594 1.406 1.703 1.406zm-2.89-5.435h-.633A13 13 0 0 0 4.5 8.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61h.675V7.354z" />
                        </svg>
                    </span>
                    Tanggal Pengiriman
                </h2>
                <input type="date" name="delivery_date" value="{{ old('delivery_date') }}"
                    class="w-full border-2 border-yellow-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-gray-700 font-semibold shadow-sm"
                    required>
            </div>
            <div>
                <h2 class="font-bold text-xl mb-2 text-yellow-700 flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-yellow-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-chat-dots-fill" viewBox="0 0 16 16">
                            <path
                                d="M16 8c0 3.866-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7M5 8a1 1 0 1 0-2 0 1 1 0 0 0 2 0m4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                        </svg>
                    </span>
                    Pesan untuk Penjual
                </h2>
                <textarea name="note" rows="2"
                    class="w-full border-2 border-yellow-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-gray-700 font-semibold shadow-sm"
                    placeholder="Tulis pesan (opsional)">{{ old('note') }}</textarea>
            </div>
            <div>
                <h2 class="font-bold text-xl mb-2 text-yellow-700 flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-yellow-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-bicycle" viewBox="0 0 16 16">
                            <path
                                d="M4 4.5a.5.5 0 0 1 .5-.5H6a.5.5 0 0 1 0 1v.5h4.14l.386-1.158A.5.5 0 0 1 11 4h1a.5.5 0 0 1 0 1h-.64l-.311.935.807 1.29a3 3 0 1 1-.848.53l-.508-.812-2.076 3.322A.5.5 0 0 1 8 10.5H5.959a3 3 0 1 1-1.815-3.274L5 5.856V5h-.5a.5.5 0 0 1-.5-.5m1.5 2.443-.508.814c.5.444.85 1.054.967 1.743h1.139zM8 9.057 9.598 6.5H6.402zM4.937 9.5a2 2 0 0 0-.487-.877l-.548.877zM3.603 8.092A2 2 0 1 0 4.937 10.5H3a.5.5 0 0 1-.424-.765zm7.947.53a2 2 0 1 0 .848-.53l1.026 1.643a.5.5 0 1 1-.848.53z" />
                        </svg>
                    </span>
                    Opsi Pengiriman
                </h2>
                <div class="flex flex-wrap gap-4">
                    <label
                        class="flex items-center gap-2 cursor-pointer bg-yellow-50 rounded-lg px-3 py-2 shadow-sm hover:bg-yellow-100 transition">
                        <span
                            class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-white border border-yellow-200">
                            <img src="{{ asset('images/GoJek.png') }}" alt="Gojek" class="w-4 h-4">
                        </span>
                        <input type="radio" name="delivery" value="gojek" class="accent-yellow-500"
                            {{ old('delivery') == 'gojek' ? 'checked' : '' }} required>
                        <span class="font-semibold">Gojek</span>
                    </label>
                    <label
                        class="flex items-center gap-2 cursor-pointer bg-yellow-50 rounded-lg px-3 py-2 shadow-sm hover:bg-yellow-100 transition">
                        <span
                            class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-white border border-yellow-200">
                            <img src="{{ asset('images/shopee.png') }}" alt="Shopee Food" class="w-4 h-4">
                        </span>
                        <input type="radio" name="delivery" value="shopeefood" class="accent-yellow-500"
                            {{ old('delivery') == 'shopeefood' ? 'checked' : '' }} required>
                        <span class="font-semibold">Shopee Food</span>
                    </label>
                </div>
            </div>
            <div>
                <h2 class="font-bold text-xl mb-2 text-yellow-700 flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-yellow-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-wallet2" viewBox="0 0 16 16">
                            <path
                                d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5z" />
                        </svg>
                    </span>
                    Metode Pembayaran
                </h2>
                <select name="payment"
                    class="w-full border-2 border-yellow-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-gray-700 font-semibold shadow-sm"
                    required>
                    <option value="">Pilih metode pembayaran</option>
                    <option value="cod" {{ old('payment') == 'cod' ? 'selected' : '' }}>Bayar di Tempat (COD)</option>
                    <option value="midtrans" {{ old('payment') == 'midtrans' ? 'selected' : '' }}>Kartu/KlikBCA/QRIS/dll
                    </option>
                </select>

            </div>
            <div>
                <h2 class="font-bold text-xl mb-2 text-yellow-700 flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-yellow-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-receipt" viewBox="0 0 16 16">
                            <path
                                d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27m.217 1.338L2 2.118v11.764l.137.274.51-.51a.5.5 0 0 1 .707 0l.646.647.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.509.509.137-.274V2.118l-.137-.274-.51.51a.5.5 0 0 1-.707 0L12 1.707l-.646.647a.5.5 0 0 1-.708 0L10 1.707l-.646.647a.5.5 0 0 1-.708 0L8 1.707l-.646.647a.5.5 0 0 1-.708 0L6 1.707l-.646.647a.5.5 0 0 1-.708 0L4 1.707l-.646.647a.5.5 0 0 1-.708 0z" />
                            <path
                                d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m8-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5" />
                        </svg>
                    </span>
                    Rincian Pembayaran
                </h2>
                <div class="bg-yellow-50 rounded-xl p-4 shadow-inner">
                    <ul class="mb-2 divide-y divide-yellow-100">
                        @php
                            $total = 0;
                            // Ringkasan bundle
                            if (isset($appliedPromo) && $appliedPromo && isset($promoMenuIds) && count($promoMenuIds)) {
                                $bundleLabel = [];
                                foreach ($promoMenuIds as $mid) {
                                    $menu = $menus->where('id', $mid)->first();
                                    $qty = is_array($cart[$mid]) ? $cart[$mid]['qty'] ?? 1 : $cart[$mid];
                                    $bundleLabel[] = $qty . 'x ' . ($menu ? $menu->name : '');
                                }
                                // Gunakan bundleSubtotal dari controller (sudah harga final setelah diskon)
                                $total += $bundleSubtotal;
                        @endphp
                            <li class="flex justify-between py-2 bg-yellow-50">
                                <span class="text-gray-700 font-bold">Promo Bundle: {{ $appliedPromo->title }} x {{ $promoQty }} <span class="text-xs text-gray-500 ml-2">({{ implode(' + ', $bundleLabel) }})</span></span>
                                <span class="font-semibold text-green-700">Rp {{ number_format(($bundleSubtotal), 0, ',', '.') }}</span>
                            </li>
                        @php }
                        // Item non-bundle
                        foreach ($menus as $menu) {
                            if (isset($promoMenuIds) && in_array($menu->id, $promoMenuIds)) continue;
                            $qty = is_array($cart[$menu->id]) ? $cart[$menu->id]['qty'] ?? 1 : $cart[$menu->id];
                            $subtotal = $menu->price * $qty;
                            $total += $subtotal;
                        @endphp
                            <li class="flex justify-between py-2">
                                <span class="text-gray-700">{{ $menu->name }} <span class="text-xs text-gray-400">x {{ $qty }}</span></span>
                                <span class="font-semibold text-yellow-700">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </li>
                        @php }
                        @endphp
                    </ul>
                    {{-- Sudah ditampilkan harga final bundle di atas, tidak perlu baris diskon terpisah --}}
                    <div class="flex justify-between font-bold border-t pt-3 text-lg">
                        <span>Total</span>
                        <span class="text-yellow-900 animate-pulse">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            @foreach ($menus as $menu)
                <input type="hidden" name="selected[]" value="{{ $menu->id }}">
            @endforeach
            <button type="submit"
                class="bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-white px-8 py-4 rounded-full shadow-lg text-lg font-bold flex items-center gap-2 justify-center transition-all duration-200 focus:ring-2 focus:ring-yellow-400 focus:outline-none active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 9V7a5 5 0 00-10 0v2M5 9h14l1 12H4L5 9zm2 4h10" />
                </svg>
                Buat Pesanan
            </button>
        </form>
    @endif
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
            .max-w-2xl {
                max-width: 100% !important;
            }

            .p-6,
            .p-4 {
                padding: 1rem !important;
            }

            .rounded-2xl,
            .rounded-xl,
            .rounded-lg {
                border-radius: 1rem !important;
            }

            .text-xl {
                font-size: 1.1rem !important;
            }

            .text-lg {
                font-size: 1rem !important;
            }

            .px-8,
            .px-6,
            .px-4 {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }

            .py-4,
            .py-3,
            .py-2 {
                padding-top: 0.7rem !important;
                padding-bottom: 0.7rem !important;
            }
        }
    </style>
@endsection

@section('scripts')
    @if (isset($snapToken) && $snapToken)
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                window.snap.embed('{{ $snapToken }}', {
                    embedId: 'midtrans-snap',
                    onSuccess: function(result) {
                        window.location.href = '{{ route('orders.index') }}';
                    },
                    onPending: function(result) {
                        alert('Transaksi belum selesai, silakan selesaikan pembayaran.');
                    },
                    onError: function(result) {
                        alert('Terjadi kesalahan pada pembayaran.');
                    },
                    onClose: function() {
                        alert('Anda menutup pembayaran tanpa menyelesaikan transaksi.');
                    }
                });
            });
        </script>
    @else
        <script>
            const paymentSelect = document.querySelector('select[name="payment"]');
            const bankOptions = document.getElementById('bank-options');

            function toggleBankOptions() {
                if (paymentSelect.value === 'transfer') {
                    bankOptions.style.display = '';
                    // Set required radio
                    bankOptions.querySelectorAll('input[type=radio]').forEach(r => r.required = true);
                } else {
                    bankOptions.style.display = 'none';
                    bankOptions.querySelectorAll('input[type=radio]').forEach(r => r.required = false);
                }
            }
            paymentSelect.addEventListener('change', toggleBankOptions);
            window.addEventListener('DOMContentLoaded', toggleBankOptions);
        </script>
    @endif
@endsection
