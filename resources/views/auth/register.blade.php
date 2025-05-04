<x-guest-layout>
<<<<<<< HEAD
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
=======
    <form method="POST" action="{{ route('register') }}">
>>>>>>> 11bef3afaaf72c1e50919d38cee6d046b0ef42c6
        @csrf

        <!-- Name -->
        <div>
<<<<<<< HEAD
            {{-- <x-input-label for="name" :value="__('Nama')" /> --}}
            <x-text-input id="name"
                class="block w-full rounded-full px-4 py-2 border-gray-300 focus:border-orange-500 focus:ring-orange-500"
                type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                placeholder="Nama Lengkap" />
=======
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
>>>>>>> 11bef3afaaf72c1e50919d38cee6d046b0ef42c6
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
<<<<<<< HEAD
        <div>
            {{-- <x-input-label for="email" :value="__('Email')" /> --}}
            <x-text-input id="email"
                class="block w-full rounded-full px-4 py-2 border-gray-300 focus:border-orange-500 focus:ring-orange-500"
                type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Email" />
=======
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
>>>>>>> 11bef3afaaf72c1e50919d38cee6d046b0ef42c6
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
<<<<<<< HEAD
        <div>
            {{-- <x-input-label for="password" :value="__('Password')" /> --}}
            <x-text-input id="password"
                class="block w-full rounded-full px-4 py-2 border-gray-300 focus:border-orange-500 focus:ring-orange-500"
                type="password" name="password" required autocomplete="new-password" placeholder="Password" />
=======
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

>>>>>>> 11bef3afaaf72c1e50919d38cee6d046b0ef42c6
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
<<<<<<< HEAD
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
            <x-primary-button
                class="w-full justify-center rounded-full py-3 bg-orange-500 hover:bg-orange-600 focus:bg-orange-700 active:bg-orange-800 text-white font-semibold">
                {{ __('Register') }}
            </x-primary-button>
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
=======
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('Sudah mempunyai akun?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Daftar') }}
            </x-primary-button>
>>>>>>> 11bef3afaaf72c1e50919d38cee6d046b0ef42c6
        </div>
    </form>
</x-guest-layout>
