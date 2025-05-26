@extends('layouts.app')

@section('title', 'Daftar Pesanan Saya')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Daftar Pesanan Saya</h1>
    @if ($orders->isEmpty())
        <div class="text-center text-gray-500 py-12">
            <svg class="mx-auto mb-4 w-16 h-16 text-yellow-300" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" />
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="#fff" />
            </svg>
            Belum ada pesanan.
        </div>
    @else
        <div class="overflow-x-auto rounded-lg shadow-lg bg-white p-4">
            <table class="min-w-full divide-y divide-yellow-200">
                <thead class="bg-gradient-to-r from-yellow-200 to-yellow-400">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-bold text-yellow-800 uppercase tracking-wider">#</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-yellow-800 uppercase tracking-wider">Tanggal
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-yellow-800 uppercase tracking-wider">Total
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-yellow-800 uppercase tracking-wider">Status
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-yellow-800 uppercase tracking-wider">Detail
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-yellow-100">
                    @foreach ($orders as $order)
                        <tr class="hover:bg-yellow-50 transition">
                            <td class="px-4 py-3 font-bold text-yellow-700">#{{ $order->id }}</td>
                            <td class="px-4 py-3">{{ $order->created_at->format('d M Y H:i') }}</td>
                            <td class="px-4 py-3 text-orange-600 font-bold">Rp
                                {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">
                                <span
                                    class="inline-block px-3 py-1 rounded-full text-xs font-bold
                                    @if ($order->status == 'pending') bg-yellow-100 text-yellow-700
                                    @elseif($order->status == 'sending') bg-blue-100 text-blue-700
                                    @elseif($order->status == 'done') bg-green-100 text-green-700
                                    @else bg-gray-100 text-gray-500 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <button onclick="toggleDetail({{ $order->id }})"
                                    class="order-detail-btn text-blue-500 font-semibold">Lihat</button>
                            </td>
                        </tr>
                        <tr id="order-detail-{{ $order->id }}"
                            style="display: none; height: 0; overflow: hidden; opacity: 0; transition: height 0.35s cubic-bezier(.4,2,.6,1), opacity 0.25s;">
                            <td colspan="5" class="bg-yellow-50 px-4 py-4">
                                <div class="font-semibold mb-2">Detail Pesanan:</div>
                                <ul class="list-disc pl-6 text-gray-700">
                                    @php
                                        $items = json_decode($order->items, true);
                                        $bundle = collect($items)->first(
                                            fn($i) => str_starts_with($i['menu_id'], 'bundle-'),
                                        );
                                        $totalNormal = 0;
                                        $diskonBundle = 0;
                                        if ($bundle) {
                                            // Hitung total normal bundle
                                            $bundleMenus = [];
                                            if (isset($order->payment_detail)) {
                                                $pd = json_decode($order->payment_detail, true);
                                                $bundleMenus = $pd['bundle_menu'] ?? [];
                                                $bundleDiscount = $pd['bundle_discount'] ?? 0;
                                            }
                                            foreach ($items as $item) {
                                                if (isset($item['menu_id']) && is_numeric($item['menu_id'])) {
                                                    $totalNormal += $item['price'] * $item['qty'];
                                                }
                                            }
                                            $diskonBundle = $totalNormal + $bundle['price'] - $order->total;
                                        }
                                    @endphp
                                    @foreach ($items as $item)
                                        <li>{{ $item['name'] }} x {{ $item['qty'] }} <span
                                                class="text-xs text-gray-400">(Rp
                                                {{ number_format($item['price'], 0, ',', '.') }})</span></li>
                                    @endforeach
                                </ul>
                                @if ($bundle)
                                    <div class="mt-2 text-sm text-green-700 font-bold">Promo Bundle: Sudah termasuk diskon
                                    </div>
                                @endif
                                <div class="mt-2 text-sm text-gray-500">Alamat: {{ $order->address }}</div>
                                <div class="text-sm text-gray-500">Catatan: {{ $order->note }}</div>
                                <div class="text-sm text-gray-500">Pengiriman: {{ ucfirst($order->delivery) }}</div>
                                <div class="text-sm text-gray-500">Pembayaran: {{ ucfirst($order->payment) }}</div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection

@section('scripts')
    <script>
        function toggleDetail(id) {
            const row = document.getElementById('order-detail-' + id);
            if (row.style.display === 'none' || row.style.height === '0px' || row.style.height === '') {
                row.style.display = 'table-row';
                const td = row.querySelector('td');
                row.style.height = '0';
                setTimeout(() => {
                    row.style.opacity = '1';
                    row.style.height = td.scrollHeight + 'px';
                }, 10);
            } else {
                row.style.opacity = '0';
                row.style.height = '0';
                setTimeout(() => {
                    row.style.display = 'none';
                }, 350);
            }
        }
    </script>
    <style>
        @media (max-width: 640px) {

            table.min-w-full th,
            table.min-w-full td {
                padding: 0.5rem 0.25rem;
                font-size: 0.85rem;
            }
        }

        /* Animasi hover pada baris order */
        tr.hover\:bg-yellow-50 {
            transition: background 0.25s, box-shadow 0.25s, transform 0.18s;
        }

        tr.hover\:bg-yellow-50:hover {
            background: #fef9c3 !important;
            box-shadow: 0 2px 12px 0 #fde04733;
            transform: scale(1.01) translateY(-2px);
            z-index: 2;
            position: relative;
        }

        /* Animasi hover pada tombol Lihat */
        .order-detail-btn {
            transition: color 0.2s, text-decoration 0.2s, transform 0.18s;
        }

        .order-detail-btn:hover {
            color: #2563eb;
            text-decoration: underline;
            transform: scale(1.08);
        }
    </style>
@endsection
