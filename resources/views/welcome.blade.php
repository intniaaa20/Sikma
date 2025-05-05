@extends('layouts.app')

@section('title', 'Tentang Aplikasi Sikma')

@section('content')
    <div class="w-full max-w-2xl mx-auto bg-white shadow-md overflow-hidden rounded-lg p-6">
        <h1 class="text-xl font-semibold text-gray-900 mb-4 text-center">
            Tentang Aplikasi Sikma
        </h1>
        <p class="text-gray-700">
            Selamat datang di Sikma! Aplikasi ini dirancang untuk [jelaskan tujuan utama aplikasi Sikma di sini, misal:
            membantu mengelola..., mempermudah proses..., menyediakan informasi tentang...].
        </p>
    </div>
    <footer class="py-10 text-center text-sm text-black/50 mt-10">
        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
    </footer>
@endsection
