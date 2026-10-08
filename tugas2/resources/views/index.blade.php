<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Toko Alat Tulis</title>
</head>
<body>
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <h3>Toko Alat Tulis &nbsp;&nbsp;&nbsp;&nbsp; <a href="{{ route('tugas2.keranjang') }}">[ Keranjang ({{ $totalItem }}) ]</a></h3>
    <hr>

    <p><strong>Daftar barang</strong></p>

    @foreach($barang as $item)
        <p>
            [img] {{ $item->nama }} &nbsp;&nbsp; Rp {{ number_format($item->harga, 0, ',', '.') }} &nbsp;&nbsp;
            <a href="{{ route('tugas2.tambah', $item->id) }}">[Masukkan ke krj]</a>
        </p>
    @endforeach
</body>
</html>
