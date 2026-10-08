<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja</title>
</head>
<body>
    <h3>Keranjang belanja &nbsp;&nbsp;&nbsp;&nbsp; Tanpa login</h3>
    <hr>

    @if(empty($items))
        <p>Keranjang belanja masih kosong.</p>
    @else
        @foreach($items as $item)
            <p>
                <strong>{{ $item['nama'] }}</strong><br>
                Rp {{ number_format($item['harga'], 0, ',', '.') }} x {{ $item['jumlah'] }} = Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                &nbsp;&nbsp;
                <a href="{{ route('tugas2.kurangQty', $item['id']) }}">[-]</a>
                {{ $item['jumlah'] }}
                <a href="{{ route('tugas2.tambahQty', $item['id']) }}">[+]</a>
                <a href="{{ route('tugas2.hapus', $item['id']) }}">[hps]</a>
            </p>
        @endforeach

        <hr>
        <p><strong>Total Rp {{ number_format($totalHarga, 0, ',', '.') }}</strong></p>

        <p><a href="{{ route('tugas2.kosongkan') }}">[ Kosongkan keranjang ]</a></p>
    @endif

    <p><a href="{{ route('tugas2.index') }}">[ Kembali ke daftar barang ]</a></p>
</body>
</html>
