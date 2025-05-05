<x-app-layout>
    <h1 class="h2 mb-4">Keranjang Belanja</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-4 p-md-5">
            @if ($cartItems && count($cartItems) > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-4">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="text-start">Produk</th>
                                <th scope="col" class="text-start">Harga</th>
                                <th scope="col" class="text-center">Jumlah</th>
                                <th scope="col" class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalPrice = 0; @endphp
                            @foreach ($cartItems as $id => $item)
                                @php $totalPrice += $item['price'] * $item['quantity']; @endphp
                                <tr>
                                    <td class="text-start">
                                        {{ $item['name'] }}
                                    </td>
                                    <td class="text-start">
                                        Rp {{ number_format($item['price'], 0, ',', '.') }}
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('cart.update', $id) }}" method="POST"
                                            class="d-inline-flex align-items-center">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}"
                                                min="1" class="form-control form-control-sm text-center me-2"
                                                style="width: 70px;">
                                            <button type="submit" class="btn btn-sm btn-outline-secondary"
                                                title="Update Kuantitas">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                    <path
                                                        d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-end">
                                        Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                    </td>
                                    <td class="text-end">
                                        <form action="{{ route('cart.remove', $id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                title="Hapus Item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                    <path
                                                        d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm-9 1h11v10.66a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1zm4 3.5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Total</td>
                                <td class="text-end fw-bold fs-5">Rp {{ number_format($totalPrice, 0, ',', '.') }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('menu.index') }}" class="btn btn-outline-secondary me-2">Lanjut Belanja</a>
                    <a href="{{ route('checkout.index') }}" class="btn btn-success">
                        Lanjut ke Checkout
                    </a>
                </div>
            @else
                <p class="text-center text-muted">Keranjang belanja Anda kosong.</p>
                <div class="text-center mt-4">
                    <a href="{{ route('menu.index') }}" class="btn btn-primary">Mulai Belanja</a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
