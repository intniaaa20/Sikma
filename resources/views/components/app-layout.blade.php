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
    {{-- Menggunakan SCSS yang dikompilasi oleh Vite --}}
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand" href="{{ route('home') }}">
                    {{ config('app.name', 'SIKMA') }}
                </a>

                <!-- Hamburger Button for Mobile -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navigation Links -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" aria-current="page"
                                href="{{ route('home') }}">
                                Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('menu.index') ? 'active' : '' }}"
                                href="{{ route('menu.index') }}">
                                Menu
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('cart.show') ? 'active' : '' }}"
                                href="{{ route('cart.show') }}">
                                Cart
                                @if (session('cart') && count(session('cart')) > 0)
                                    <span class="badge bg-danger rounded-pill ms-1">{{ count(session('cart')) }}</span>
                                @endif
                            </a>
                        </li>
                        {{-- Auth Links --}}
                        @guest
                            <li class="nav-item">
                                <a href="{{ route('login') }}"
                                    class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
                            </li>
                            {{-- Tambahkan link Register jika perlu --}}
                            {{-- @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}">Register</a>
                                </li>
                            @endif --}}
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUser" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ Auth::user()->name }} {{-- Asumsi ada kolom name --}}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownUser">
                                    {{-- Tambahkan link Profile jika perlu --}}
                                    {{-- <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li> --}}
                                    {{-- <li><hr class="dropdown-divider"></li> --}}
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                        {{-- End Auth Links --}}
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Page Content -->
    <main class="flex-grow-1 container mt-4 mb-4">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-light mt-auto py-3 shadow-sm">
        <div class="container text-center">
            <span class="text-muted">&copy; {{ date('Y') }} {{ config('app.name', 'SIKMA') }}. All rights
                reserved.</span>
        </div>
    </footer>

</body>

</html>
