<x-guest-layout>
<<<<<<< HEAD
    {{-- Remove Old Logo Placeholder --}}
    {{-- <x-auth-session-status class="mb-4" :status="session('status')" /> --}}
    {{-- End Remove Static Logo --}}

    {{-- New Logo --}}
    <div class="flex justify-center mb-4">
        <img src="{{ asset('images/logo.png') }}" alt="Logo SIKMA" class="w-24 h-auto">
    </div>

    {{-- Titles --}}
    <h1 class="text-2xl font-bold text-center mb-1 text-gray-800">Login</h1>
    <p class="text-center text-gray-600 mb-6">Selamat datang kembali di SIKMA</p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
=======
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
>>>>>>> 11bef3afaaf72c1e50919d38cee6d046b0ef42c6
        @csrf

        <!-- Email Address -->
        <div>
<<<<<<< HEAD
            {{-- <x-input-label for="email" :value="__('Email')" /> --}}
            <x-text-input id="email"
                class="block w-full rounded-full px-4 py-2 border-gray-300 focus:border-orange-500 focus:ring-orange-500"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                placeholder="Email" />
=======
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
>>>>>>> 11bef3afaaf72c1e50919d38cee6d046b0ef42c6
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
<<<<<<< HEAD
        <div>
            {{-- <x-input-label for="password" :value="__('Password')" /> --}}
            <x-text-input id="password"
                class="block w-full rounded-full px-4 py-2 border-gray-300 focus:border-orange-500 focus:ring-orange-500"
                type="password" name="password" required autocomplete="current-password" placeholder="Password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between text-sm">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-orange-600 shadow-sm focus:ring-orange-500" name="remember">
                <span class="ms-2 text-gray-600">{{ __('Ingat Saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="underline text-gray-600 hover:text-orange-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500"
=======
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Ingat Saya') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
>>>>>>> 11bef3afaaf72c1e50919d38cee6d046b0ef42c6
                    href="{{ route('password.request') }}">
                    {{ __('Lupa Password?') }}
                </a>
            @endif
<<<<<<< HEAD
        </div>

        <!-- Login Button -->
        <div>
            <x-primary-button
                class="w-full justify-center rounded-full py-3 bg-orange-500 hover:bg-orange-600 focus:bg-orange-700 active:bg-orange-800 text-white font-semibold">
                {{ __('Login') }}
            </x-primary-button>
        </div>

        {{-- Register Link --}}
        <div class="text-center mt-6">
            <p class="text-sm text-gray-600">
                Belum punya akun?
                <a class="underline font-medium text-orange-600 hover:text-orange-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500"
                    href="{{ route('register') }}">
                    {{ __('Daftar di sini') }}
                </a>
            </p>
        </div>
=======

            <x-primary-button class="ms-3">
                {{ __('Masuk') }}
            </x-primary-button>
        </div>

        {{-- Add Register Link --}}
        <div class="text-center mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('register') }}">
                {{ __('Belum mempunyai akun?') }}
            </a>
        </div>
        {{-- End Add Register Link --}}
>>>>>>> 11bef3afaaf72c1e50919d38cee6d046b0ef42c6
    </form>
</x-guest-layout>
