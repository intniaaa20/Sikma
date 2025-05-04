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
<<<<<<< HEAD
    <style>
        .bg-warung-full {
            background-image: url("{{ asset('images/warung.png') }}");
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="antialiased">
    {{-- Main container with full-screen background and positioning form to the right --}}
    <div class="min-h-screen flex justify-end items-center p-6 bg-warung-full">
        {{-- Form Card --}}
        <div class="w-full max-w-md bg-white shadow-xl rounded-2xl p-8">
=======
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="relative">
            <!-- Canvas untuk Logo 3D -->
            <canvas id="logo-canvas" class="interactive-logo-canvas mb-4"></canvas>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
>>>>>>> 11bef3afaaf72c1e50919d38cee6d046b0ef42c6
            {{ $slot }}
        </div>
    </div>
</body>

</html>
