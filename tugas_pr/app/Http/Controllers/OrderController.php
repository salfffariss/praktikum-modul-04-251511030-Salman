<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Menampilkan form checkout
     */
    public function checkoutForm()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('warning', 'Keranjang belanja kosong. Silakan pilih barang terlebih dahulu.');
        }

        $products = Product::whereIn('id_barang', array_keys($cart))->get();
        $items = [];
        $totalHarga = 0;

        foreach ($products as $product) {
            $qty = $cart[$product->id_barang];
            $subtotal = $product->harga * $qty;
            $totalHarga += $subtotal;

            $items[] = [
                'id_barang' => $product->id_barang,
                'nama_barang' => $product->nama_barang,
                'harga' => $product->harga,
                'jumlah' => $qty,
                'subtotal' => $subtotal,
            ];
        }

        return view('orders.checkout', compact('items', 'totalHarga'));
    }

    /**
     * Memproses checkout pesanan
     */
    public function prosesCheckout(Request $request)
    {
        $request->validate([
            'alamat_pengiriman' => 'required',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        $products = Product::whereIn('id_barang', array_keys($cart))->get();

        // Validasi stok ulang sebelum transaksi
        foreach ($products as $product) {
            $qty = $cart[$product->id_barang];
            if ($qty > $product->stok) {
                return redirect()->route('cart.index')->with('error', 'Stok untuk barang ' . $product->nama_barang . ' tidak mencukupi (sisa: ' . $product->stok . ').');
            }
        }

        DB::transaction(function () use ($products, $cart, $request) {
            // Generate id_order unik (contoh: ORD + format tanggal waktu + 3 digit acak)
            $id_order = 'ORD' . date('ymd') . rand(100, 999);

            $totalHarga = 0;
            foreach ($products as $product) {
                $totalHarga += ($product->harga * $cart[$product->id_barang]);
            }

            // 1. Simpan tabel orders
            Order::create([
                'id_order' => $id_order,
                'id_user' => Auth::user()->id_user,
                'tanggal_order' => now(),
                'total_harga' => $totalHarga,
                'alamat_pengiriman' => $request->alamat_pengiriman,
            ]);

            // 2. Simpan order_details dan kurangi stok products
            foreach ($products as $product) {
                $qty = $cart[$product->id_barang];

                OrderDetail::create([
                    'id_order' => $id_order,
                    'id_barang' => $product->id_barang,
                    'harga_satuan' => $product->harga,
                    'jumlah_beli' => $qty,
                ]);

                // Kurangi stok barang
                $product->decrement('stok', $qty);
            }

            // 3. Kosongkan keranjang
            session()->forget('cart');
        });

        return redirect()->route('orders.index')->with('success', 'Checkout berhasil! Pesanan Anda telah diproses.');
    }

    /**
     * Menampilkan riwayat pesanan milik pengguna
     */
    public function riwayatPesanan()
    {
        $orders = Order::where('id_user', Auth::user()->id_user)
            ->with(['details.product'])
            ->orderBy('tanggal_order', 'desc')
            ->get();

        return view('orders.index', compact('orders'));
    }
}
