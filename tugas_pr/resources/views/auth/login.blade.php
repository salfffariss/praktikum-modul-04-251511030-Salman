@extends('layouts.app')

@section('title', 'Login Pengguna')

@section('content')
    <h3>Form Login</h3>
    <p>Silakan login untuk dapat memasukkan barang ke keranjang belanja dan melakukan checkout.</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <p>
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus>
        </p>
        <p>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required>
        </p>
        <p>
            <button type="submit">Masuk / Login</button>
        </p>
    </form>

    <p><em>(Akun Demo: Username = <strong>budi</strong>, Password = <strong>password123</strong>)</em></p>
@endsection
