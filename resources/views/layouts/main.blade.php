{{-- File: resources/views/layouts/main.blade.php --}}
{{-- Layout ini untuk halaman utama aplikasi (setelah login atau halaman publik) --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Laravel'))</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    {{-- Memuat CSS dan JS menggunakan Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    {{-- Container utama dengan background dinamis (terang/gelap) --}}
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        {{-- Header dengan Navigasi --}}
        <header class="bg-white dark:bg-gray-800 shadow">
            {{-- Container header dengan lebar maksimum dan padding --}}
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                {{-- Link ke halaman utama --}}
                <a href="/" class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                    Aplikasi Saya {{-- Nama Aplikasi Anda --}}
                </a>
                {{-- Bagian Navigasi Kanan (Login/Logout) --}}
                <div>
                    {{-- Tampilkan jika user sudah login --}}
                    @auth
                        <span class="text-gray-800 dark:text-gray-200 mr-4">Halo, {{ Auth::user()->name }}</span>
                        {{-- Form Logout (Metode POST, pakai CSRF) --}}
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline-none focus:underline">
                                Logout
                            </button>
                        </form>
                    @endauth
                    {{-- Tampilkan jika user adalah tamu (belum login) --}}
                    @guest
                        {{-- Link Login --}}
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 mr-4">Log in</a>
                        {{-- Link Register (jika route 'register' ada) --}}
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                    @endguest
                </div>
            </div>
        </header>

        {{-- Konten Utama Halaman --}}
        <main>
            <div class="py-12"> {{-- Padding vertikal --}}
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> {{-- Container lebar maksimum dan padding horizontal --}}
                    {{-- Menampilkan pesan flash global (status & warning) --}}
                    @if (session('status'))
                        <div class="mb-4 p-4 bg-green-100 dark:bg-green-800/30 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-300 rounded-lg">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('warning'))
                         <div class="mb-4 p-4 bg-yellow-100 dark:bg-yellow-800/30 border border-yellow-400 dark:border-yellow-600 text-yellow-700 dark:text-yellow-300 rounded-lg">
                             {{ session('warning') }}
                        </div>
                    @endif

                    {{-- Tempat konten dari view anak akan dimasukkan --}}
                    @yield('content')
                </div>
            </div>
        </main>

        {{-- (Opsional) Footer --}}
        <footer class="text-center py-4 text-sm text-gray-500 dark:text-gray-400 border-t border-gray-200 dark:border-gray-700 mt-8">
             Hak Cipta © {{ date('Y') }} Aplikasi Saya
        </footer>
    </div> {{-- Akhir dari min-h-screen --}}

    {{-- Tempat untuk script spesifik halaman dari view anak --}}
    @yield('scripts')
</body>
</html>