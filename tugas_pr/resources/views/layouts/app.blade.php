<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Toko Online')</title>
</head>
<body>
    <h2>Program Toko Online</h2>
    <div>
        <a href="{{ route('products.index') }}">[ Katalog Barang ]</a>
        @auth
            <a href="{{ route('cart.index') }}">[ Keranjang ({{ array_sum(session('cart', [])) }}) ]</a>
            <a href="{{ route('orders.index') }}">[ Riwayat Pesanan ]</a>
            <span> | Login sebagai: <strong>{{ Auth::user()->nama_lengkap }}</strong> </span>
            <a href="{{ route('logout') }}">[ Logout ]</a>
        @else
            <span> | Anda belum login: </span>
            <a href="{{ route('login') }}">[ Login ]</a>
        @endauth
    </div>
    <hr>

    @if(session('success'))
        <p><strong>SUKSES:</strong> {{ session('success') }}</p>
    @endif

    @if(session('warning'))
        <p><strong>PERINGATAN:</strong> {{ session('warning') }}</p>
    @endif

    @if(session('error'))
        <p><strong>ERROR:</strong> {{ session('error') }}</p>
    @endif

    @if($errors->any())
        <p><strong>ERROR:</strong></p>
        <ul>
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    @endif

    @yield('content')

</body>
</html>
