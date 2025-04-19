{{-- File: resources/views/welcome.blade.php --}}
{{-- Halaman ini menggunakan layout 'main' --}}
@extends('layouts.main')

@section('title', 'Selamat Datang')

@section('content')
    {{-- Container dasar di dalam layout main --}}
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <h1 class="text-2xl font-semibold mb-4">Selamat Datang di Aplikasi Kami</h1>
            <p>Ini adalah halaman utama publik.</p>
            {{-- Jika user login, tampilkan pesan berbeda --}}
            @auth
             <p class="mt-4">Anda sedang login sebagai {{ Auth::user()->name }}.</p>
             {{-- Tambahkan link ke dashboard atau fitur lain jika perlu --}}
            @endauth
             {{-- Jika tamu, mungkin ada info lain --}}

        </div>
    </div>
@endsection