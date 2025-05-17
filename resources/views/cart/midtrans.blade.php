@extends('layouts.app')

@section('title', 'Pembayaran Midtrans')

@section('content')
    <div class="max-w-xl mx-auto bg-white rounded-2xl shadow-2xl p-6 mt-8 border border-yellow-100 animate-fade-in">
        <h1 class="text-2xl font-bold mb-4">Pembayaran Pesanan</h1>
        <div class="mb-4">
            <strong>ID Pesanan:</strong> {{ $order->id }}<br>
            <strong>Total:</strong> Rp {{ number_format($order->total, 0, ',', '.') }}
        </div>
        <div id="midtrans-snap"></div>
        <button onclick="window.location.href='{{ route('orders.index') }}'"
            class="mt-6 px-6 py-2 bg-yellow-500 text-white rounded shadow font-bold">Lihat Daftar Pesanan</button>
    </div>
@endsection

@section('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.snap.pay(@json($snapToken), {
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
                    alert('Anda menutup popup pembayaran tanpa menyelesaikan transaksi.');
                }
            });
        });
    </script>
@endsection
