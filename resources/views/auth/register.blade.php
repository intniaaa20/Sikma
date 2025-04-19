@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <h2>Register</h2>

    {{-- Menampilkan error validasi --}}
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

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <label for="name">Nama:</label><br>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
            @error('name')
                 <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-top: 10px;">
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
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
            <label for="password_confirmation">Konfirmasi Password:</label><br>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
            {{-- Error untuk konfirmasi password otomatis ditangani oleh rule 'confirmed' --}}
        </div>

        <div style="margin-top: 15px;">
            <button type="submit">Register</button>
        </div>
    </form>

     <div style="margin-top: 15px;">
        Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
    </div>
@endsection 