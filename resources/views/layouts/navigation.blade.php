<nav x-data="{ open: false }" class="bg-white border-b border-gray-100" style="font-family: 'Poppins', sans-serif;">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if (Auth::user()?->hasRole('admin'))
                        <x-nav-link :href="url('/admin')" :active="request()->is('admin')">
                            {{ __('Admin') }}
                        </x-nav-link>
                        <x-nav-link :href="url('/menu')" :active="request()->is('menu')">
                            {{ __('Menu') }}
                        </x-nav-link>
                        <x-nav-link :href="url('/product')" :active="request()->is('product')">
                            {{ __('Product') }}
                        </x-nav-link>
                        <x-nav-link :href="url('/chat')" :active="request()->is('chat')">
                            {{ __('Chat') }}
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="url('/cart')" :active="request()->is('cart')">
                            {{ __('Cart') }}
                        </x-nav-link>
                        <x-nav-link :href="url('/order')" :active="request()->is('order')">
                            {{ __('Order') }}
                        </x-nav-link>
                        <x-nav-link :href="url('/history')" :active="request()->is('history')">
                            {{ __('History') }}
                        </x-nav-link>
                        <x-nav-link :href="url('/chat')" :active="request()->is('chat')">
                            {{ __('Chat') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6" style="font-family: 'Poppins', sans-serif;">
                <!-- Cart Icon with Notification Badge -->

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4"
                                    xmlns="http://www.w3.org/2000/sv
                                    viewBox="0 0 20
                                    20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @if (Auth::user()?->hasRole('admin', 'web'))
                            <x-dropdown-link :href="url('/admin')">
                                <span class="flex items-center gap-x-2">
                                    <x-heroicon-o-cog-6-tooth class="w-5 h-5 text-gray-500" />
                                    {{ __('Admin Panel') }}
                                </span>
                            </x-dropdown-link>
                        @endif

                        <x-dropdown-link :href="route('profile.edit')">
                            <span class="flex items-center gap-x-2">
                                <x-heroicon-o-user-circle class="w-5 h-5 text-gray-500" />
                                {{ __('Profile') }}
                            </span>
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                        </form>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <span class="flex items-center gap-x-2">
                                    <x-heroicon-o-arrow-left-on-rectangle class="w-5 h-5 text-gray-500" />
                                    {{ __('Log Out') }}
                                </span>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                @if (Auth::user()?->hasRole('admin', 'web'))
                    <x-responsive-nav-link :href="url('/admin')">
                        <span class="flex items-center gap-x-2">
                            <x-heroicon-o-cog-6-tooth class="w-5 h-5 text-gray-500" />
                            {{ __('Admin Panel') }}
                        </span>
                    </x-responsive-nav-link>
                @endif

                <x-responsive-nav-link :href="route('profile.edit')">
                    <span class="flex items-center gap-x-2">
                        <x-heroicon-o-user-circle class="w-5 h-5 text-gray-500" />
                        {{ __('Profile') }}
                    </span>
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        <span class="flex items-center gap-x-2">
                            <x-heroicon-o-arrow-left-on-rectangle class="w-5 h-5 text-gray-500" />
                            {{ __('Log Out') }}
                        </span>
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
