<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Tampilkan halaman keranjang belanja
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $items = [];
        $totalHarga = 0;

        if (!empty($cart)) {
            $products = Product::whereIn('id_barang', array_keys($cart))->get();

            foreach ($products as $product) {
                $qty = $cart[$product->id_barang];
                $subtotal = $product->harga * $qty;
                $totalHarga += $subtotal;

                $items[] = [
                    'id_barang' => $product->id_barang,
                    'nama_barang' => $product->nama_barang,
                    'harga' => $product->harga,
                    'stok' => $product->stok,
                    'gambar' => $product->gambar,
                    'jumlah' => $qty,
                    'subtotal' => $subtotal,
                ];
            }
        }

        return view('cart.index', compact('items', 'totalHarga'));
    }

    /**
     * Tambah barang ke keranjang
     */
    public function tambah($id_barang)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Silakan login terlebih dahulu untuk menambahkan barang ke keranjang.');
        }

        $product = Product::findOrFail($id_barang);

        // Validasi: Barang dengan stok 0 tidak dapat dibeli
        if ($product->stok <= 0) {
            return back()->with('error', 'Barang ' . $product->nama_barang . ' sedang habis (stok 0).');
        }

        $cart = session()->get('cart', []);
        $currentQty = isset($cart[$id_barang]) ? $cart[$id_barang] : 0;

        // Validasi: Jumlah yang dibeli tidak boleh melebihi stok
        if ($currentQty + 1 > $product->stok) {
            return back()->with('error', 'Jumlah barang ' . $product->nama_barang . ' tidak boleh melebihi stok yang tersedia (Maksimal ' . $product->stok . ').');
        }

        $cart[$id_barang] = $currentQty + 1;
        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Barang ' . $product->nama_barang . ' berhasil ditambahkan ke keranjang.');
    }

    /**
     * Tombol [+] tambah jumlah di keranjang
     */
    public function tambahQty($id_barang)
    {
        $product = Product::findOrFail($id_barang);
        $cart = session()->get('cart', []);

        if (isset($cart[$id_barang])) {
            if ($cart[$id_barang] + 1 > $product->stok) {
                return back()->with('error', 'Jumlah tidak boleh melebihi stok yang tersedia (Stok tersisa: ' . $product->stok . ').');
            }
            $cart[$id_barang]++;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }

    /**
     * Tombol [-] kurangi jumlah di keranjang
     */
    public function kurangQty($id_barang)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id_barang])) {
            $cart[$id_barang]--;
            if ($cart[$id_barang] <= 0) {
                unset($cart[$id_barang]);
            }
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }

    /**
     * Hapus barang dari keranjang
     */
    public function hapus($id_barang)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id_barang])) {
            unset($cart[$id_barang]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Barang berhasil dihapus dari keranjang.');
    }
}
