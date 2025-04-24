<x-app-layout>
    {{-- Container sudah ada di app-layout --}}
    <h1 class="h2 mb-4">Menu Kami</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        @forelse ($menus as $menu)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    {{-- Placeholder for image --}}
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                        style="height: 180px;">
                        <span class="text-muted">Image Placeholder</span>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title mb-1">{{ $menu->name }}</h5>
                        <p class="card-text text-muted small mb-2 flex-grow-1">
                            {{ $menu->description ?? 'Tidak ada deskripsi.' }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-bold text-primary fs-5">
                                Rp {{ number_format($menu->price, 0, ',', '.') }}
                            </span>
                        </div>
                        <form action="{{ route('cart.add', $menu) }}" method="POST" class="mt-auto">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">
                                Tambah ke Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center text-muted">Belum ada menu yang tersedia saat ini.</p>
            </div>
        @endforelse
    </div>
</x-app-layout>
