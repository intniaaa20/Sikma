@extends('layouts.app')

@section('title', 'Histori Pesanan Selesai')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Histori Pesanan Selesai</h1>
    @if ($orders->isEmpty())
        <div class="text-center text-gray-500 py-12">
            <svg class="mx-auto mb-4 w-16 h-16 text-yellow-300" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" />
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="#fff" />
            </svg>
            Belum ada pesanan selesai.
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
                        <th class="px-4 py-3 text-left text-xs font-bold text-yellow-800 uppercase tracking-wider">Menu</th>
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
                                <ul class="list-disc pl-4 text-gray-700">
                                    @foreach (json_decode($order->items, true) as $item)
                                        <li>{{ $item['name'] }} x {{ $item['qty'] }}</li>
                                    @endforeach
                                </ul>
                                <div class="mt-2 text-xs text-gray-500">
                                    <div><b>Alamat:</b> {{ $order->address }}</div>
                                    <div><b>Catatan:</b> {{ $order->note }}</div>
                                    <div><b>Pengiriman:</b> {{ ucfirst($order->delivery) }}</div>
                                    <div><b>Pembayaran:</b> {{ ucfirst($order->payment) }}</div>
                                    @if ($order->delivery_date)
                                        <div><b>Waktu Selesai:</b>
                                            {{ \Carbon\Carbon::parse($order->delivery_date)->format('d M Y H:i') }}</div>
                                    @endif
                                    <div><b>Status:</b> <span
                                            class="font-bold text-green-600">{{ ucfirst($order->status) }}</span></div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
