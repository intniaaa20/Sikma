<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    <style>
        /* You can add custom styles here if needed */
    </style>
</head>

<body class="antialiased font-sans">

    {{-- Navigation Bar --}}
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                {{-- Logo on the left --}}
                <div class="flex items-center">
                    <a href="/">
                        <x-application-logo class="block h-10 w-auto text-gray-800" />
                    </a>
                </div>

                {{-- Login/Register/Dashboard Links on the right --}}
                <div class="flex items-center">
                    @if (Route::has('login'))
                        <nav class="flex space-x-4">
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                    class="rounded-md px-3 py-2 text-sm font-medium text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="rounded-md px-3 py-2 text-sm font-medium text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]">
                                    Log in
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="rounded-md px-3 py-2 text-sm font-medium text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </div>
            </div>
        </div>
    </nav>
    {{-- End Navigation Bar --}}

    {{-- Main Content Area --}}
    <div class="bg-gray-100 text-black/50 min-h-screen flex flex-col items-center pt-10 sm:pt-16">
        {{-- Removed Logo from here --}}

        {{-- Description Card --}}
        <div class="w-full max-w-2xl mt-6 sm:mt-0 bg-white shadow-md overflow-hidden rounded-lg p-6">
            <h1 class="text-xl font-semibold text-gray-900 mb-4 text-center">
                Tentang Aplikasi Sikma
            </h1>
            <p class="text-gray-700">
                Selamat datang di Sikma! Aplikasi ini dirancang untuk [jelaskan tujuan utama aplikasi Sikma di sini,
                misal: membantu mengelola..., mempermudah proses..., menyediakan informasi tentang...].
            </p>
        </div>

        {{-- Removed Login/Register/Dashboard Links from here --}}

        {{-- Footer --}}
        <footer class="py-10 text-center text-sm text-black/50 mt-auto">
            Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
        </footer>
    </div>
</body>

</html>
