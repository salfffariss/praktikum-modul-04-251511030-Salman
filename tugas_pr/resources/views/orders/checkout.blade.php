@extends('layouts.app')

@section('title', 'Konfirmasi Checkout')

@section('content')
    <h3>Konfirmasi Checkout Pesanan</h3>
    <p>Periksa kembali barang yang Anda beli sebelum menyelesaikan transaksi.</p>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Harga Satuan</th>
                <th>Jumlah Beli</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td><strong>{{ $item['nama_barang'] }}</strong></td>
                    <td>Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                    <td align="center">{{ $item['jumlah'] }}</td>
                    <td>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" align="right">Total Bayar (Ongkir Diabaikan):</th>
                <th align="left">Rp {{ number_format($totalHarga, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <br>
    <form method="POST" action="{{ route('checkout.process') }}">
        @csrf
        <fieldset>
            <legend><strong>Informasi Pengiriman</strong></legend>
            <p>
                <strong>Nama Pembeli:</strong> {{ Auth::user()->nama_lengkap }} ({{ Auth::user()->username }})
            </p>
            <p>
                <strong>Nomor Telepon:</strong> {{ Auth::user()->no_hp ?? '-' }}
            </p>
            <p>
                <label for="alamat_pengiriman"><strong>Alamat Pengiriman:</strong></label><br>
                <textarea id="alamat_pengiriman" name="alamat_pengiriman" rows="4" cols="50" required>{{ old('alamat_pengiriman', Auth::user()->alamat) }}</textarea>
            </p>
        </fieldset>

        <br>
        <button type="submit" onclick="return confirm('Apakah data pesanan sudah sesuai?')">[ Konfirmasi Pembelian & Checkout ]</button>
        &nbsp;&nbsp;
        <a href="{{ route('cart.index') }}">[ Kembali ke Keranjang ]</a>
    </form>
@endsection
