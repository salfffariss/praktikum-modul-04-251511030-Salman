@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')
    <h3>Riwayat Pesanan Saya</h3>

    @if($orders->isEmpty())
        <p>Anda belum memiliki riwayat pesanan.</p>
        <p><a href="{{ route('products.index') }}">[ &laquo; Mulai Belanja ]</a></p>
    @else
        @foreach($orders as $order)
            <fieldset>
                <legend><strong>Pesanan #{{ $order->id_order }}</strong></legend>
                <p>
                    <strong>Waktu Checkout:</strong> {{ $order->tanggal_order }}<br>
                    <strong>Alamat Pengiriman:</strong> {{ $order->alamat_pengiriman }}<br>
                    <strong>Total Bayar:</strong> Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                </p>

                <p><strong>Detail Barang yang Dibeli:</strong></p>
                <table border="1" cellpadding="6" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Harga Satuan (Saat Beli)</th>
                            <th>Jumlah Beli</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->details as $detail)
                            <tr>
                                <td>{{ $detail->id_barang }}</td>
                                <td>{{ $detail->product->nama_barang ?? 'Barang tidak ditemukan' }}</td>
                                <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                <td align="center">{{ $detail->jumlah_beli }}</td>
                                <td>Rp {{ number_format($detail->harga_satuan * $detail->jumlah_beli, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </fieldset>
            <br>
        @endforeach
    @endif
@endsection
