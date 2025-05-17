<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <style>
        body,
        html,
        * {
            font-family: 'Poppins', sans-serif !important;
        }
    </style>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased">
    <!-- Toast Notification -->
    @if (session('success') || session('error'))
        <div id="toast-notification"
            class="fixed top-6 right-6 z-50 px-6 py-4 rounded-lg shadow-lg text-white font-semibold transition-all duration-500 animate-fade-in-down"
            style="background: {{ session('success') ? '#22c55e' : '#ef4444' }}; min-width:200px;">
            {{ session('success') ?? session('error') }}
        </div>
        <script>
            setTimeout(() => {
                const toast = document.getElementById('toast-notification');
                if (toast) toast.style.display = 'none';
            }, 2500);
        </script>
    @endif
    <div id="sidebarApp" class="min-h-screen flex bg-gray-100">
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'w-72' : 'w-20'"
            class="transition-all duration-300 bg-white shadow-md h-screen flex flex-col relative group z-50"
            style="position: sticky; top: 0; height: 100vh;" x-data="{ sidebarOpen: JSON.parse(localStorage.getItem('sidebarOpen') ?? 'true') }" x-init="$watch('sidebarOpen', val => localStorage.setItem('sidebarOpen', val))">
            <!-- Toggle Button -->
            <button @click="sidebarOpen = !sidebarOpen"
                class="absolute top-4 right-[-14px] z-50 bg-yellow-400 border border-yellow-500 rounded-full w-7 h-7 flex items-center justify-center shadow hover:bg-yellow-300 transition">
                <svg x-show="sidebarOpen" class="w-4 h-4 text-yellow-900" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                <svg x-show="!sidebarOpen" class="w-4 h-4 text-yellow-900" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            <div class="flex items-center gap-3 p-6 border-b bg-white/80" :class="sidebarOpen ? '' : 'justify-center'"
                style="font-family: 'Poppins', sans-serif;">
                <img src="/images/logo.png" alt="Pak Jhon"
                    class="w-14 h-14 rounded-full object-cover object-center aspect-square border-4 border-yellow-400 shadow">
                <template x-if="sidebarOpen">
                    <div>
                        <div class="font-extrabold text-2xl text-yellow-600 drop-shadow">PAK JHON</div>
                        <div class="text-xs font-semibold text-yellow-600 tracking-wide">JAGONYA AYAM BAKAR</div>
                    </div>
                </template>
            </div>
            <nav class="flex-1 p-4">
                <ul class="space-y-2">
                    @auth
                        <li>
                            <a href="/"
                                class="flex items-center gap-3 px-4 py-3 rounded-lg font-semibold text-gray-700 hover:bg-yellow-200 transition @if (request()->is('/')) bg-yellow-400 text-white @endif sidebar-anim-hover">
                                <svg class="w-5 h-5 text-yellow-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7A1 1 0 003 11h1v6a1 1 0 001 1h3a1 1 0 001-1v-3h2v3a1 1 0 001 1h3a1 1 0 001-1v-6h1a1 1 0 00.707-1.707l-7-7z" />
                                </svg>
                                <span x-show="sidebarOpen" class="transition-all duration-200">Home</span>
                            </a>
                        </li>
                        <li>
                            <a href="/menu"
                                class="flex items-center gap-3 px-4 py-3 rounded-lg font-semibold text-gray-700 hover:bg-yellow-200 transition @if (request()->is('menu')) bg-yellow-400 text-white @endif sidebar-anim-hover">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-cart-fill text-yellow-600" viewBox="0 0 50 50">
                                    <path
                                        d="M48.894 15.154l-3.935 30.846h-13.291l-3.919-31h16.226l3.207-11.077 1.818.548-3.077 10.66 2.971.023zm-23.024 17.846s.497-4-6.395-4h-10.976c-6.882 0-6.395 4-6.395 4h23.766zm-23.766 9s-.487 4 6.395 4h10.977c6.892 0 6.395-4 6.395-4h-23.767zm22.735-2c1.128 0 2.039-1.114 2.039-2.499 0-1.393-.911-2.501-2.039-2.501h-21.799c-1.123 0-2.04 1.108-2.04 2.501 0 1.385.917 2.499 2.04 2.499h21.799z" />
                                </svg>
                                <span x-show="sidebarOpen" class="transition-all duration-200">Product</span>
                            </a>
                        </li>
                        @if (!auth()->user()->hasRole('admin'))
                            @php
                                $cartCount = 0;
                                if (auth()->check() && !auth()->user()->hasRole('admin')) {
                                    $cart = session('cart', []);
                                    if (is_array($cart)) {
                                        foreach ($cart as $qty) {
                                            $cartCount +=
                                                is_array($qty) && isset($qty['quantity'])
                                                    ? $qty['quantity']
                                                    : (is_numeric($qty)
                                                        ? $qty
                                                        : 0);
                                        }
                                    }
                                }
                            @endphp
                            <li>
                                <a href="/cart"
                                    class="relative flex items-center gap-3 px-4 py-3 rounded-lg font-semibold text-gray-700 hover:bg-yellow-200 transition @if (request()->is('cart')) bg-yellow-400 text-white @endif sidebar-cart-hover sidebar-anim-hover">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-cart-fill text-yellow-600" viewBox="0 0 16 16">
                                        <path
                                            d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                                    </svg>
                                    <span x-show="sidebarOpen" class="transition-all duration-200">Cart</span>
                                    @if ($cartCount > 0)
                                        <span
                                            class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold rounded-full px-2 py-0.5 z-10">
                                            {{ $cartCount }}
                                        </span>
                                    @endif
                                </a>
                            </li>
                            {{-- 
                            <li>
                                <a href="/order"
                                    class="flex items-center gap-3 px-4 py-3 rounded-lg font-semibold text-gray-700 hover:bg-yellow-200 transition @if (request()->is('order')) bg-yellow-400 text-white @endif sidebar-anim-hover">
                                    <svg class="w-5 h-5 text-yellow-600 flex-shrink-0" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M16 6V4a2 2 0 00-2-2H6a2 2 0 00-2 2v2H2v2h1v8a2 2 0 002 2h10a2 2 0 002-2V8h1V6h-3zm-2 0H6V4h8v2z" />
                                    </svg>
                                    <span x-show="sidebarOpen" class="transition-all duration-200">Order</span>
                                </a>
                            </li>
                            <li>
                                <a href="/history"
                                    class="flex items-center gap-3 px-4 py-3 rounded-lg font-semibold text-gray-700 hover:bg-yellow-200 transition @if (request()->is('history')) bg-yellow-400 text-white @endif sidebar-anim-hover">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-clock-fill text-yellow-600" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z" />
                                    </svg>
                                    <span x-show="sidebarOpen" class="transition-all duration-200">History</span>
                                </a>
                            </li>
                            --}}
                            <!-- Tampilkan menu "Order" dan "History" hanya untuk customer (bukan admin) -->
                            @if (!auth()->user()->hasRole('admin'))
                                <li>
                                    <a href="/order"
                                        class="flex items-center gap-3 px-4 py-3 rounded-lg font-semibold text-gray-700 hover:bg-yellow-200 transition @if (request()->is('order')) bg-yellow-400 text-white @endif sidebar-anim-hover">
                                        <svg class="w-5 h-5 text-yellow-600 flex-shrink-0" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M16 6V4a2 2 0 00-2-2H6a2 2 0 00-2 2v2H2v2h1v8a2 2 0 002 2h10a2 2 0 002-2V8h1V6h-3zm-2 0H6V4h8v2z" />
                                        </svg>
                                        <span x-show="sidebarOpen" class="transition-all duration-200">Order</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/history"
                                        class="flex items-center gap-3 px-4 py-3 rounded-lg font-semibold text-gray-700 hover:bg-yellow-200 transition @if (request()->is('history')) bg-yellow-400 text-white @endif sidebar-anim-hover">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-clock-fill text-yellow-600"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z" />
                                        </svg>
                                        <span x-show="sidebarOpen" class="transition-all duration-200">History</span>
                                    </a>
                                </li>
                            @endif
                        @endif
                        <li>
                            <a href="/messages"
                                class="flex items-center gap-3 px-4 py-3 rounded-lg font-semibold text-gray-700 hover:bg-yellow-200 transition @if (request()->is('messages')) bg-yellow-400 text-white @endif sidebar-anim-hover">
                                <svg class="w-5 h-5 text-yellow-600 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H6l-4 4V5z" />
                                </svg>
                                <span x-show="sidebarOpen" class="transition-all duration-200">Message</span>
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="/"
                                class="flex items-center gap-3 px-4 py-3 rounded-lg font-semibold text-gray-700 hover:bg-yellow-200 transition @if (request()->is('/')) bg-yellow-400 text-white @endif sidebar-anim-hover">
                                <svg class="w-5 h-5 text-yellow-600 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7A1 1 0 003 11h1v6a1 1 0 001 1h3a1 1 0 001-1v-3h2v3a1 1 0 001 1h3a1 1 0 001-1v-6h1a1 1 0 00.707-1.707l-7-7z" />
                                </svg>
                                <span x-show="sidebarOpen" class="transition-all duration-200">Home</span>
                            </a>
                        </li>
                    @endauth
                </ul>
            </nav>
        </aside>
        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Headbar -->
            <header class="w-full bg-white shadow flex items-center justify-between px-8 py-4 h-16 sticky top-0 z-40">
                <div class="text-xl font-extrabold text-yellow-600 tracking-wide">
                    WARUNG PAK JHON
                </div>
                <div class="flex items-center gap-4">
                    @auth
                        <div class="relative">
                            <button class="flex items-center gap-2 focus:outline-none" id="profileDropdownButton"
                                onclick="toggleDropdown()">
                                <span class="text-gray-700 font-semibold">{{ Auth::user()->name }}</span>
                                <svg id="profileDropdownArrow"
                                    class="w-4 h-4 text-gray-500 transition-transform duration-200" fill="none"
                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div id="profileDropdownMenu"
                                class="absolute right-0 mt-2 w-44 bg-white border rounded shadow-lg opacity-0 pointer-events-none transition-all duration-200 z-50"
                                tabindex="-1">
                                <a href="{{ route('profile.edit') }}"
                                    class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 10a4 4 0 100-8 4 4 0 000 8zm0 2c-4 0-7 2-7 4v2h14v-2c0-2-3-4-7-4z" />
                                    </svg>
                                    Profil
                                </a>
                                @if (auth()->user() && auth()->user()->hasRole('admin'))
                                    <a href="/admin"
                                        class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor"
                                            stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11.25 2.25c.966 0 1.75.784 1.75 1.75v.5a7.5 7.5 0 0 1 2.25.938l.354-.354a1.75 1.75 0 1 1 2.475 2.475l-.354.354a7.5 7.5 0 0 1 .938 2.25h.5c.966 0 1.75.784 1.75 1.75s-.784 1.75-1.75 1.75h-.5a7.5 7.5 0 0 1-.938 2.25l.354.354a1.75 1.75 0 1 1-2.475 2.475l-.354-.354a7.5 7.5 0 0 1-2.25.938v.5c0 .966-.784 1.75-1.75 1.75s-1.75-.784-1.75-1.75v-.5a7.5 7.5 0 0 1-2.25-.938l-.354.354a1.75 1.75 0 1 1-2.475-2.475l.354-.354a7.5 7.5 0 0 1-.938-2.25h-.5c-.966 0-1.75-.784-1.75-1.75s.784-1.75 1.75-1.75h.5a7.5 7.5 0 0 1 .938-2.25l-.354-.354a1.75 1.75 0 1 1 2.475-2.475l.354.354a7.5 7.5 0 0 1 2.25-.938v-.5c0-.966.784-1.75 1.75-1.75zM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                        </svg>
                                        Halaman Admin
                                    </a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center gap-2 w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor"
                                            stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1" />
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                        <script>
                            let dropdownOpen = false;

                            function toggleDropdown() {
                                const menu = document.getElementById('profileDropdownMenu');
                                const arrow = document.getElementById('profileDropdownArrow');
                                dropdownOpen = !dropdownOpen;
                                if (dropdownOpen) {
                                    menu.classList.remove('opacity-0', 'pointer-events-none');
                                    menu.classList.add('opacity-100');
                                    arrow.style.transform = 'rotate(180deg)';
                                } else {
                                    menu.classList.add('opacity-0', 'pointer-events-none');
                                    menu.classList.remove('opacity-100');
                                    arrow.style.transform = 'rotate(0deg)';
                                }
                            }
                            // Close dropdown on click outside
                            document.addEventListener('click', function(event) {
                                const button = document.getElementById('profileDropdownButton');
                                const menu = document.getElementById('profileDropdownMenu');
                                const arrow = document.getElementById('profileDropdownArrow');
                                if (!button.contains(event.target) && !menu.contains(event.target)) {
                                    menu.classList.add('opacity-0', 'pointer-events-none');
                                    menu.classList.remove('opacity-100');
                                    arrow.style.transform = 'rotate(0deg)';
                                    dropdownOpen = false;
                                }
                            });
                        </script>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-sm bg-gradient-to-r from-orange-400 to-yellow-400 hover:from-orange-500 hover:to-yellow-500 text-white px-5 py-2 rounded-full font-bold shadow-lg transition-all duration-200 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 12h14m-7-7l7 7-7 7" />
                            </svg>
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                            class="text-sm bg-white/80 hover:bg-yellow-100 text-yellow-700 px-5 py-2 rounded-full font-bold shadow-lg transition-all duration-200 border border-yellow-300 ml-2 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Register
                        </a>
                    @endauth
                </div>
            </header>
            <main class="flex-1 p-8">
                @yield('content')
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        /* Animasi toast */
        @keyframes fade-in-down {
            0% {
                opacity: 0;
                transform: translateY(-30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-down {
            animation: fade-in-down 0.5s;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            background: #fef9c3;
        }

        ::-webkit-scrollbar-thumb {
            background: #fde047;
            border-radius: 8px;
        }

        /* Animasi hover pada menu cart di sidebar */
        .sidebar-cart-hover {
            transition: background 0.22s, color 0.18s, transform 0.18s;
        }

        .sidebar-cart-hover:hover {
            background: #fef08a !important;
            color: #d97706 !important;
            transform: scale(1.04) translateX(4px);
            box-shadow: 0 2px 12px 0 #fde04733;
            font-weight: bold;
        }

        /* Animasi hover pada semua menu sidebar */
        .sidebar-anim-hover {
            transition: background 0.22s, color 0.18s, transform 0.18s;
        }

        .sidebar-anim-hover:hover {
            background: #fef08a !important;
            color: #d97706 !important;
            transform: scale(1.04) translateX(4px);
            box-shadow: 0 2px 12px 0 #fde04733;
            font-weight: bold;
        }
    </style>
    @yield('scripts')
</body>

</html>
