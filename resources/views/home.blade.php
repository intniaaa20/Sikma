<x-app-layout>
    {{-- Container utama dihapus karena sudah ada di app-layout --}}
    {{-- <div class="py-5"> --}}
    {{-- <div class="container"> --}}
    <div class="card shadow-sm">
        <div class="card-body p-4 p-md-5">
            <h1 class="h3 mb-3">Selamat Datang di SIKMA!</h1>
            <p class="mb-4">Pesan makanan dan minuman favorit Anda dengan mudah.</p>
            <a href="{{ route('menu.index') }}" class="btn btn-primary">
                Lihat Menu
            </a>
        </div>
    </div>
    {{-- </div> --}}
    {{-- </div> --}}
</x-app-layout>
