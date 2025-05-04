<x-app-layout>
<<<<<<< HEAD
    {{-- Konten utama dashboard --}}
=======
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

>>>>>>> 11bef3afaaf72c1e50919d38cee6d046b0ef42c6
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
<<<<<<< HEAD
                    <h3 class="text-lg font-medium mb-4">Selamat Datang!</h3>
=======
>>>>>>> 11bef3afaaf72c1e50919d38cee6d046b0ef42c6
                    {{ __("You're logged in!") }}
                </div>
            </div>

            {{-- Add Sikma Description Section --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        Tentang Aplikasi Sikma
                    </h3>
                    <p>
                        Selamat datang di Sikma! Aplikasi ini dirancang untuk [jelaskan tujuan utama aplikasi Sikma di
                        sini, misal: membantu mengelola..., mempermudah proses..., menyediakan informasi tentang...].
                    </p>
                </div>
            </div>
            {{-- End Sikma Description Section --}}

        </div>
    </div>
</x-app-layout>
