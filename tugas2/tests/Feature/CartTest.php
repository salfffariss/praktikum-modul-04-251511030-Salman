<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Barang;

class CartTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_halaman_index_bisa_diakses(): void
    {
        $response = $this->get('/tugas2/index');
        $response->assertStatus(200);
        $response->assertSee('Toko Alat Tulis');
        $response->assertSee('Buku Tulis');
    }

    public function test_tambah_ke_keranjang_dan_perhitungan_total(): void
    {
        // Tambah Buku Tulis (id: 1) dua kali
        $this->get('/tugas2/tambah/1');
        $this->get('/tugas2/tambah/1');

        // Tambah Pulpen (id: 2) satu kali
        $this->get('/tugas2/tambah/2');

        // Buka halaman keranjang
        $response = $this->get('/tugas2/keranjang');
        $response->assertStatus(200);

        // Subtotal buku tulis: 5000 x 2 = 10.000
        $response->assertSee('10.000');
        // Subtotal pulpen: 3000 x 1 = 3.000
        $response->assertSee('3.000');
        // Total keseluruhan: 13.000
        $response->assertSee('13.000');
    }

    public function test_tombol_plus_minus_dan_otomatis_hapus(): void
    {
        // Mulai dengan 1 pulpen
        $this->withSession(['cart' => [2 => 1]]);

        // Tekan tambah (+)
        $this->get('/tugas2/tambah-qty/2');
        $this->assertEquals(2, session('cart')[2]);

        // Tekan kurang (-)
        $this->get('/tugas2/kurang-qty/2');
        $this->assertEquals(1, session('cart')[2]);

        // Tekan kurang (-) lagi hingga 0 -> harus otomatis terhapus
        $this->get('/tugas2/kurang-qty/2');
        $this->assertArrayNotHasKey(2, session('cart', []));
    }

    public function test_hapus_dan_kosongkan_keranjang(): void
    {
        $this->withSession(['cart' => [1 => 2, 2 => 1]]);

        // Hapus item id 1
        $this->get('/tugas2/hapus/1');
        $this->assertArrayNotHasKey(1, session('cart'));
        $this->assertEquals(1, session('cart')[2]);

        // Kosongkan keranjang
        $this->get('/tugas2/kosongkan');
        $this->assertEmpty(session('cart', []));
    }
}
