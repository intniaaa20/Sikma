<x-guest-layout>
    {{-- Remove Old Logo Placeholder --}}
    {{-- ... (removed comments if any) ... --}}

    {{-- New Logo --}}
    <div class="flex justify-center mb-4">
        <img src="{{ asset('images/logo.png') }}" alt="Logo SIKMA" class="w-24 h-auto">
    </div>

    {{-- Titles --}}
    <h1 class="text-2xl font-bold text-center mb-1 text-gray-800">Register</h1>
    <p class="text-center text-gray-600 mb-6">Selamat datang di SIKMA</p>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            {{-- <x-input-label for="name" :value="__('Nama')" /> --}}
            <x-text-input id="name"
                class="block w-full rounded-full px-4 py-2 border-gray-300 focus:border-orange-500 focus:ring-orange-500"
                type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                placeholder="Nama Lengkap" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            {{-- <x-input-label for="email" :value="__('Email')" /> --}}
            <x-text-input id="email"
                class="block w-full rounded-full px-4 py-2 border-gray-300 focus:border-orange-500 focus:ring-orange-500"
                type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            {{-- <x-input-label for="password" :value="__('Password')" /> --}}
            <x-text-input id="password"
                class="block w-full rounded-full px-4 py-2 border-gray-300 focus:border-orange-500 focus:ring-orange-500"
                type="password" name="password" required autocomplete="new-password" placeholder="Password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            {{-- <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" /> --}}
            <x-text-input id="password_confirmation"
                class="block w-full rounded-full px-4 py-2 border-gray-300 focus:border-orange-500 focus:ring-orange-500"
                type="password" name="password_confirmation" required autocomplete="new-password"
                placeholder="Konfirmasi Password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Register Button -->
        <div>
            <button type="submit"
                class="w-full flex justify-center items-center gap-2 rounded-full py-3 bg-gradient-to-r from-orange-400 to-yellow-400 hover:from-orange-500 hover:to-yellow-500 focus:bg-orange-700 active:bg-orange-800 text-white font-bold text-lg shadow-lg transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7-7l7 7-7 7" />
                </svg>
                {{ __('Register') }}
            </button>
        </div>

        {{-- Login Link --}}
        <div class="text-center mt-6">
            <p class="text-sm text-gray-600">
                Sudah punya akun?
                <a class="underline font-medium text-orange-600 hover:text-orange-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500"
                    href="{{ route('login') }}">
                    {{ __('Masuk di sini') }}
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
