@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Keranjang Belanja</h1>
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif
    @if (count($cart) && $menus->count())
        <form method="POST" action="{{ route('cart.clear') }}" class="mb-4">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Kosongkan
                Keranjang</button>
        </form>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded shadow">
                <thead>
                    <tr class="bg-yellow-100 text-yellow-700">
                        <th class="px-4 py-2">Menu</th>
                        <th class="px-4 py-2">Harga</th>
                        <th class="px-4 py-2">Jumlah</th>
                        <th class="px-4 py-2">Subtotal</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach ($menus as $menu)
                        @php
                            $subtotal = $menu->price * $cart[$menu->id];
                            $total += $subtotal;
                        @endphp
                        <tr>
                            <td class="px-4 py-2 flex items-center gap-2">
                                @if ($menu->image)
                                    <img src="{{ url('storage/' . $menu->image) }}" alt="{{ $menu->name }}"
                                        class="w-12 h-12 object-cover rounded">
                                @endif
                                <span>{{ $menu->name }}</span>
                            </td>
                            <td class="px-4 py-2">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">
                                <form method="POST" action="{{ route('cart.update', $menu->id) }}"
                                    class="flex items-center gap-2">
                                    @csrf
                                    <input type="number" name="qty" value="{{ $cart[$menu->id] }}" min="1"
                                        class="w-16 border rounded px-2 py-1 text-center" />
                                    <button type="submit"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded">Ubah</button>
                                </form>
                            </td>
                            <td class="px-4 py-2">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">
                                <form method="POST" action="{{ route('cart.remove', $menu->id) }}">
                                    @csrf
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="font-bold bg-yellow-50">
                        <td colspan="3" class="px-4 py-2 text-right">Total</td>
                        <td class="px-4 py-2">Rp {{ number_format($total, 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @else
        <div class="text-center text-gray-500">Keranjang belanja kosong.</div>
    @endif
@endsection
