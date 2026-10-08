<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'id_barang' => 'BRG001',
                'nama_barang' => 'Laptop Asus Vivobook',
                'deskripsi' => 'Laptop harian kencang untuk kerja dan kuliah',
                'harga' => 7500000,
                'stok' => 5,
                'gambar' => 'laptop.jpg',
            ],
            [
                'id_barang' => 'BRG002',
                'nama_barang' => 'Mouse Wireless Logitech',
                'deskripsi' => 'Mouse tanpa kabel ergonomis dan hemat daya',
                'harga' => 150000,
                'stok' => 20,
                'gambar' => 'mouse.jpg',
            ],
            [
                'id_barang' => 'BRG003',
                'nama_barang' => 'Keyboard Mechanical RGB',
                'deskripsi' => 'Keyboard tactile responsif dengan lampu RGB',
                'harga' => 350000,
                'stok' => 12,
                'gambar' => 'keyboard.jpg',
            ],
            [
                'id_barang' => 'BRG004',
                'nama_barang' => 'Headset Gaming HyperX',
                'deskripsi' => 'Headset suara surround jernih dengan mikrofon',
                'harga' => 450000,
                'stok' => 8,
                'gambar' => 'headset.jpg',
            ],
            [
                'id_barang' => 'BRG005',
                'nama_barang' => 'Monitor LG 24 Inch',
                'deskripsi' => 'Layar IPS Full HD 75Hz nyaman untuk mata',
                'harga' => 1250000,
                'stok' => 6,
                'gambar' => 'monitor.jpg',
            ],
            [
                'id_barang' => 'BRG006',
                'nama_barang' => 'Flashdisk Sandisk 64GB',
                'deskripsi' => 'Media penyimpanan praktis USB 3.0 super cepat',
                'harga' => 85000,
                'stok' => 30,
                'gambar' => 'flashdisk.jpg',
            ],
            [
                'id_barang' => 'BRG007',
                'nama_barang' => 'Harddisk Eksternal 1TB',
                'deskripsi' => 'Penyimpanan cadangan file dan backup berkapasitas besar',
                'harga' => 750000,
                'stok' => 10,
                'gambar' => 'harddisk.jpg',
            ],
            [
                'id_barang' => 'BRG008',
                'nama_barang' => 'Webcam Full HD 1080p',
                'deskripsi' => 'Kamera jernih untuk meeting online dan streaming',
                'harga' => 250000,
                'stok' => 15,
                'gambar' => 'webcam.jpg',
            ],
            [
                'id_barang' => 'BRG009',
                'nama_barang' => 'Speaker Bluetooth JBL',
                'deskripsi' => 'Speaker portabel suara bass jernih tahan air',
                'harga' => 500000,
                'stok' => 7,
                'gambar' => 'speaker.jpg',
            ],
            [
                'id_barang' => 'BRG010',
                'nama_barang' => 'Printer Canon Pixma',
                'deskripsi' => 'Printer serbaguna cetak, scan, dan fotokopi',
                'harga' => 950000,
                'stok' => 0, // Stok 0 untuk pengujian: tidak dapat dibeli
                'gambar' => 'printer.jpg',
            ],
        ];

        foreach ($products as $item) {
            Product::create($item);
        }
    }
}
