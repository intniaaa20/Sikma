@extends('layouts.app') {{-- Asumsi Anda punya layout --}}

@section('title', 'Login')

@section('content')
    <h2>Login</h2>

    {{-- Menampilkan error validasi umum --}}
    @if ($errors->any())
        <div style="color: red; margin-bottom: 15px;">
            <strong>Error:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

     {{-- Menampilkan pesan status (misal setelah registrasi) --}}
    @if (session('status'))
        <div style="color: green; margin-bottom: 15px;">
            {{ session('status') }}
        </div>
    @endif


    <form method="POST" action="{{ route('login') }}">
        @csrf {{-- Token CSRF (Wajib!) --}}

        <div>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
             {{-- Menampilkan error spesifik untuk email --}}
            @error('email')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-top: 10px;">
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required>
             @error('password')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-top: 10px;">
            <input type="checkbox" name="remember" id="remember">
            <label for="remember">Ingat Saya</label>
        </div>

        <div style="margin-top: 15px;">
            <button type="submit">Login</button>
        </div>
    </form>

    <div style="margin-top: 15px;">
        Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
    </div>
@endsection