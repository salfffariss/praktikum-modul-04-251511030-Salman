@extends('layouts.app')

@section('title', 'Katalog Barang')

@section('content')
    <h3>Daftar Barang yang Dijual</h3>
    <p>Pengunjung dapat melihat daftar barang tanpa login. Untuk memasukkan barang ke keranjang dan checkout, silakan login.</p>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Gambar</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $item)
                <tr>
                    <td align="center">
                        <img src="{{ asset('images/' . $item->gambar) }}" alt="{{ $item->nama_barang }}" width="80">
                    </td>
                    <td>{{ $item->id_barang }}</td>
                    <td><strong>{{ $item->nama_barang }}</strong></td>
                    <td>{{ $item->deskripsi }}</td>
                    <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td align="center">
                        @if($item->stok == 0)
                            <strong>0</strong>
                        @else
                            {{ $item->stok }}
                        @endif
                    </td>
                    <td align="center">
                        @if($item->stok <= 0)
                            <em>[Stok Habis]</em>
                        @else
                            <a href="{{ route('cart.add', $item->id_barang) }}">[+ Masukkan ke Keranjang]</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
