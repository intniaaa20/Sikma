<x-guest-layout>
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
        @csrf

        <!-- Email Address -->
        <div>
            {{-- <x-input-label for="email" :value="__('Email')" /> --}}
            <x-text-input id="email"
                class="block w-full rounded-full px-4 py-2 border-gray-300 focus:border-orange-500 focus:ring-orange-500"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                placeholder="Email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
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
                    href="{{ route('password.request') }}">
                    {{ __('Lupa Password?') }}
                </a>
            @endif
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
    </form>
</x-guest-layout>
