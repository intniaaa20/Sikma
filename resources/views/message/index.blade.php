@extends('layouts.app')

@section('title', 'Pesan')

@section('content')
    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-2xl p-6 mt-8 border border-yellow-100 animate-fade-in">
        <h1 class="text-2xl font-bold mb-4 flex items-center gap-2">
            <svg class="w-7 h-7 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.77 9.77 0 01-4-.8L3 21l1.8-4A7.97 7.97 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            Pesan
            <button onclick="location.reload()"
                class="ml-auto px-3 py-1 rounded bg-yellow-100 hover:bg-yellow-300 text-yellow-700 text-xs font-semibold transition">Refresh</button>
        </h1>
        @if (session('success'))
            <div class="mb-2 p-2 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-2 p-2 bg-red-100 text-red-700 rounded">{{ session('error') }}</div>
        @endif
        <div class="flex gap-6">
            @if ($users)
                <div class="w-1/3 border-r pr-4">
                    <h2 class="font-semibold mb-2 text-yellow-700">
                        @if (auth()->user()->role === 'admin')
                            Pilih Customer
                        @else
                            Pilih Admin
                        @endif
                    </h2>
                    <ul>
                        @foreach ($users as $user)
                            <li class="mb-2">
                                <a href="?user_id={{ $user->id }}"
                                    class="block px-3 py-2 rounded-lg transition {{ isset($selectedUser) && $selectedUser && $selectedUser->id == $user->id ? 'bg-yellow-400 text-white font-bold shadow' : 'hover:bg-yellow-100' }}">
                                    <span class="inline-flex items-center gap-2">
                                        <span
                                            class="w-2 h-2 rounded-full {{ $user->is_blocked ? 'bg-red-400' : 'bg-green-400' }}"></span>
                                        {{ $user->name }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="flex-1 flex flex-col">
                @if ($selectedUser)
                    <div class="mb-4 flex items-center gap-2">
                        <span class="font-semibold">Chat dengan:</span>
                        <span class="text-yellow-700 font-bold">{{ $selectedUser->name }}</span>
                    </div>
                    <div class="bg-yellow-50 rounded-lg p-4 mb-4 h-80 overflow-y-auto flex flex-col gap-2" id="chat-box">
                        @forelse($messages as $msg)
                            <div class="flex {{ $msg->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                                <div
                                    class="max-w-xs px-4 py-2 rounded-2xl shadow text-sm animate-fade-in-fast {{ $msg->sender_id == auth()->id() ? 'bg-yellow-300 text-gray-900 rounded-br-none' : 'bg-gray-200 text-gray-700 rounded-bl-none' }}">
                                    {{ $msg->message }}
                                    <div class="text-xs text-gray-400 mt-1 text-right">
                                        {{ $msg->created_at->format('d M H:i') }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-gray-400 text-center">Belum ada pesan.</div>
                        @endforelse
                    </div>
                    @if (isset($selectedUser) && $selectedUser)
                        <form method="POST" action="{{ route('messages.store') }}"
                            class="flex gap-2 mt-auto animate-fade-in-fast">
                            @csrf
                            <input type="hidden" name="receiver_id" value="{{ $selectedUser->id }}">
                            <input type="text" name="message"
                                class="flex-1 border rounded-lg px-3 py-2 focus:ring-2 focus:ring-yellow-400 outline-none"
                                placeholder="Tulis pesan..." required autocomplete="off">
                            <button type="submit"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-bold transition">Kirim</button>
                        </form>
                    @endif
                @else
                    <div class="flex flex-col items-center justify-center h-full text-gray-400 animate-fade-in">
                        <svg class="w-16 h-16 mb-2 text-yellow-200" fill="none" stroke="currentColor" stroke-width="1.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.77 9.77 0 01-4-.8L3 21l1.8-4A7.97 7.97 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        Pilih user untuk mulai chat.
                    </div>
                @endif
            </div>
        </div>
    </div>
    <style>
        .animate-fade-in {
            animation: fadeIn .7s;
        }

        .animate-fade-in-fast {
            animation: fadeIn .3s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }
    </style>
    <script>
        // Scroll ke bawah otomatis saat load dan setelah submit
        function scrollChatToBottom() {
            var chatBox = document.getElementById('chat-box');
            if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;
        }
        document.addEventListener('DOMContentLoaded', scrollChatToBottom);
        document.querySelectorAll('form[action$="messages"]').forEach(form => {
            form.addEventListener('submit', function() {
                setTimeout(scrollChatToBottom, 300);
            });
        });
    </script>
@endsection
