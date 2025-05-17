<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        // Admin bisa pilih user, customer hanya bisa chat admin
        if ($user->role === 'admin') {
            $users = User::where('role', 'customer')->get();
            // Debug: jika $users kosong, log ke laravel.log
            if ($users->isEmpty()) {
                \Log::info('Tidak ada customer ditemukan di database.');
            }
            $selectedUserId = $request->input('user_id');
            $selectedUser = null;
            $messages = collect();
            if ($selectedUserId) {
                $selectedUser = $users->where('id', $selectedUserId)->first();
                if ($selectedUser) {
                    $messages = Chat::where(function ($q) use ($selectedUser, $user) {
                        $q->where('sender_id', $user->id)->where('receiver_id', $selectedUser->id);
                    })->orWhere(function ($q) use ($selectedUser, $user) {
                        $q->where('sender_id', $selectedUser->id)->where('receiver_id', $user->id);
                    })->orderBy('created_at')->get();
                }
            }
            // Debug: kirim $users ke view untuk dd jika perlu
            return view('message.index', compact('users', 'selectedUser', 'messages'));
        } else {
            // Ambil semua admin
            $admins = User::where('role', 'admin')->get();
            $selectedUserId = $request->input('user_id');
            $selectedUser = null;
            $messages = collect();
            if ($selectedUserId) {
                $selectedUser = $admins->where('id', $selectedUserId)->first();
                if ($selectedUser) {
                    $messages = Chat::where(function ($q) use ($user, $selectedUser) {
                        $q->where('sender_id', $user->id)->where('receiver_id', $selectedUser->id);
                    })->orWhere(function ($q) use ($user, $selectedUser) {
                        $q->where('sender_id', $selectedUser->id)->where('receiver_id', $user->id);
                    })->orderBy('created_at')->get();
                }
            }
            // Jika tidak memilih admin, default ke admin pertama jika ada
            if (!$selectedUser && $admins->count() > 0) {
                $selectedUser = $admins->first();
                $messages = Chat::where(function ($q) use ($user, $selectedUser) {
                    $q->where('sender_id', $user->id)->where('receiver_id', $selectedUser->id);
                })->orWhere(function ($q) use ($user, $selectedUser) {
                    $q->where('sender_id', $selectedUser->id)->where('receiver_id', $user->id);
                })->orderBy('created_at')->get();
            }
            return view('message.index', [
                'users' => $admins,
                'selectedUser' => $selectedUser,
                'messages' => $messages
            ]);
        }
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'message' => 'required|string',
            'receiver_id' => 'required|exists:users,id',
        ]);
        Chat::create([
            'sender_id' => $user->id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);
        return back();
    }
}
