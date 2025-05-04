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
            {{ $slot }}
        </div>
    </div>
</body>

</html>
