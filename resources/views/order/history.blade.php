@extends('layouts.app')

@section('title', 'Histori Pesanan Selesai')

@section('content')
    @if (session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-800 border border-green-300">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 p-3 rounded bg-red-100 text-red-800 border border-red-300">
            {{ session('error') }}
        </div>
    @endif
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
                                    @php
                                        $items = json_decode($order->items, true);
                                        $bundle = collect($items)->first(
                                            fn($i) => str_starts_with($i['menu_id'], 'bundle-'),
                                        );
                                    @endphp
                                    @foreach ($items as $item)
                                        <li>
                                            {{ $item['name'] }} x {{ $item['qty'] }}
                                            @php
                                                $menuId = $item['menu_id'] ?? ($item['id'] ?? '');
                                                $review = null;
                                                if (is_numeric($menuId)) {
                                                    $review = \App\Models\Review::where('order_id', $order->id)
                                                        ->where('menu_id', $menuId)
                                                        ->first();
                                                }
                                            @endphp
                                            @if ($review)
                                                @if ($review->comment)
                                                    <div class="text-xs text-gray-600 italic mt-1">"{{ $review->comment }}"
                                                    </div>
                                                @endif
                                            @elseif (is_numeric($menuId))
                                                <form action="{{ route('review.store') }}" method="POST"
                                                    class="mt-2 flex flex-col gap-1">
                                                    @csrf
                                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                    <input type="hidden" name="menu_id" value="{{ $menuId }}">
                                                    <div class="flex items-center gap-2 mt-1">
                                                        <label for="rating" class="text-xs">Rating:</label>
                                                        <select name="rating" id="rating"
                                                            class="border border-yellow-200 rounded px-2 py-1 text-xs"
                                                            required>
                                                            <option value="">Pilih rating</option>
                                                            @for ($i = 1; $i <= 10; $i++)
                                                                <option value="{{ $i }}">{{ $i }}
                                                                </option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                    <textarea name="comment" rows="1" class="w-full border border-yellow-200 rounded px-2 py-1 text-xs mt-1"
                                                        placeholder="Tulis komentar..." required></textarea>
                                                    <button type="submit"
                                                        class="text-xs bg-yellow-400 hover:bg-yellow-500 text-white rounded px-2 py-1 mt-1">Kirim
                                                        Review</button>
                                                </form>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                                @if ($bundle)
                                    <div class="mt-2 text-sm text-green-700 font-bold">Promo Bundle: Sudah termasuk diskon
                                    </div>
                                @endif
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
