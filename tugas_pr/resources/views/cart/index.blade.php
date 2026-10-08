@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
    <h3>Keranjang Belanja (Shopping Cart)</h3>

    @if(empty($items))
        <p>Keranjang belanja Anda masih kosong.</p>
        <p><a href="{{ route('products.index') }}">[ &laquo; Kembali ke Katalog Barang ]</a></p>
    @else
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama Barang</th>
                    <th>Harga Satuan</th>
                    <th>Stok Tersedia</th>
                    <th>Jumlah Beli</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td align="center">
                            <img src="{{ asset('images/' . $item['gambar']) }}" alt="{{ $item['nama_barang'] }}" width="60">
                        </td>
                        <td><strong>{{ $item['nama_barang'] }}</strong></td>
                        <td>Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                        <td align="center">{{ $item['stok'] }}</td>
                        <td align="center">
                            <a href="{{ route('cart.kurangQty', $item['id_barang']) }}">[-]</a>
                            <strong> {{ $item['jumlah'] }} </strong>
                            <a href="{{ route('cart.tambahQty', $item['id_barang']) }}">[+]</a>
                        </td>
                        <td>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                        <td align="center">
                            <a href="{{ route('cart.hapus', $item['id_barang']) }}" onclick="return confirm('Hapus barang ini dari keranjang?')">[Hapus]</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" align="right">Total Harga:</th>
                    <th colspan="2" align="left">Rp {{ number_format($totalHarga, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>

        <br>
        <p>
            <a href="{{ route('products.index') }}">[ &laquo; Lanjut Belanja ]</a>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a href="{{ route('checkout.form') }}"><strong>[ Lanjut ke Checkout &raquo; ]</strong></a>
        </p>
    @endif
@endsection
