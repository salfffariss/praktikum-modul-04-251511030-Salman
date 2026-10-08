<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class CartController extends Controller
{
    /**
     * Menampilkan daftar barang yang dijual (localhost/tugas2/index)
     */
    public function index()
    {
        $barang = Barang::all();
        $cart = session()->get('cart', []);

        // Total seluruh item (jumlah unit) di keranjang
        $totalItem = array_sum($cart);

        return view('index', compact('barang', 'totalItem'));
    }

    /**
     * Menampilkan halaman keranjang belanja (localhost/tugas2/keranjang)
     */
    public function keranjang()
    {
        $cart = session()->get('cart', []);
        $items = [];
        $totalHarga = 0;

        if (!empty($cart)) {
            // Mengambil data nama dan harga asli dari database MySQL (hanya ID dan jumlah di session)
            $produkList = Barang::whereIn('id', array_keys($cart))->get();

            foreach ($produkList as $produk) {
                $qty = $cart[$produk->id];
                $subtotal = $produk->harga * $qty;
                $totalHarga += $subtotal;

                $items[] = [
                    'id' => $produk->id,
                    'nama' => $produk->nama,
                    'harga' => $produk->harga,
                    'jumlah' => $qty,
                    'subtotal' => $subtotal,
                ];
            }
        }

        return view('keranjang', compact('items', 'totalHarga'));
    }

    /**
     * Menambahkan produk ke keranjang belanja
     * Jika produk sudah ada, jumlahnya bertambah
     */
    public function tambah($id)
    {
        $barang = Barang::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        session()->put('cart', $cart);

        return redirect()->route('tugas2.index')->with('success', $barang->nama . ' berhasil ditambahkan ke keranjang.');
    }

    /**
     * Tombol + : Menambah jumlah item di keranjang
     */
    public function tambahJumlah($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]++;
            session()->put('cart', $cart);
        }

        return redirect()->route('tugas2.keranjang');
    }

    /**
     * Tombol - : Mengurangi jumlah item. Jika menjadi 0, otomatis dihapus
     */
    public function kurangiJumlah($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]--;
            if ($cart[$id] <= 0) {
                unset($cart[$id]);
            }
            session()->put('cart', $cart);
        }

        return redirect()->route('tugas2.keranjang');
    }

    /**
     * Tombol [hps] : Menghapus satu item dari keranjang
     */
    public function hapus($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('tugas2.keranjang');
    }

    /**
     * Tombol [ Kosongkan keranjang ] : Menghapus seluruh isi keranjang
     */
    public function kosongkan()
    {
        session()->forget('cart');

        return redirect()->route('tugas2.keranjang');
    }
}
