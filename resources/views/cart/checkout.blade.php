@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Checkout</h1>
    <form method="POST" action="{{ route('checkout.process') }}"
        class="max-w-2xl mx-auto bg-white rounded-2xl shadow-2xl p-6 flex flex-col gap-8 border border-yellow-100 animate-fade-in">
        @csrf
        <div>
            <h2 class="font-bold text-xl mb-2 text-yellow-700 flex items-center gap-2">
                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-yellow-100">
                    <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-4V7a4 4 0 10-8 0v3m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-yellow-100">
                    <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 10h.01M12 14h.01M16 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                    <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 7v4a1 1 0 001 1h3m10-5v4a1 1 0 01-1 1h-3m-4 4h4m-2 0v4m0 0a2 2 0 104 0v-4a2 2 0 10-4 0z" />
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
                    <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 0V4m0 8v8" />
                    </svg>
                </span>
                Metode Pembayaran
            </h2>
            <select name="payment"
                class="w-full border-2 border-yellow-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-gray-700 font-semibold shadow-sm"
                required>
                <option value="">Pilih metode pembayaran</option>
                <option value="cod" {{ old('payment') == 'cod' ? 'selected' : '' }}>Bayar di Tempat (COD)</option>
                <option value="transfer" {{ old('payment') == 'transfer' ? 'selected' : '' }}>Virtual Account</option>
                <option value="qris" {{ old('payment') == 'qris' ? 'selected' : '' }}>QRIS</option>
            </select>

        </div>
        <div>
            <h2 class="font-bold text-xl mb-2 text-yellow-700 flex items-center gap-2">
                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-yellow-100">
                    <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h1l3 8h8l3-8h1" />
                    </svg>
                </span>
                Rincian Pembayaran
            </h2>
            <div class="bg-yellow-50 rounded-xl p-4 shadow-inner">
                <ul class="mb-2 divide-y divide-yellow-100">
                    @php $total = 0; @endphp
                    @foreach ($menus as $menu)
                        @php
                            $subtotal = $menu->price * $cart[$menu->id];
                            $total += $subtotal;
                        @endphp
                        <li class="flex justify-between py-2">
                            <span class="text-gray-700">{{ $menu->name }} <span class="text-xs text-gray-400">x
                                    {{ $cart[$menu->id] }}</span></span>
                            <span class="font-semibold text-yellow-700">Rp
                                {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </li>
                    @endforeach
                </ul>
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
@endsection
