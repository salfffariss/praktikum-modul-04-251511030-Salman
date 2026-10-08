<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;

class TokoOnlineTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_katalog_dapat_dilihat_tanpa_login(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Daftar Barang yang Dijual');
        $response->assertSee('Laptop Asus Vivobook');
        $response->assertSee('Printer Canon Pixma');
        $response->assertSee('[Stok Habis]');
    }

    public function test_tambah_ke_keranjang_tanpa_login_dialihkan_ke_login(): void
    {
        $response = $this->get('/tambah-keranjang/BRG001');
        $response->assertRedirect('/login');
    }

    public function test_barang_stok_habis_tidak_dapat_dibeli(): void
    {
        $user = User::where('username', 'budi')->first();

        // BRG010 stoknya 0
        $response = $this->actingAs($user)->get('/tambah-keranjang/BRG010');
        $response->assertSessionHas('error');
        $this->assertEmpty(session('cart', []));
    }

    public function test_user_login_bisa_tambah_ke_keranjang_dan_validasi_stok(): void
    {
        $user = User::where('username', 'budi')->first();

        // Tambah mouse (BRG002, stok 20)
        $this->actingAs($user)->get('/tambah-keranjang/BRG002');
        $this->assertEquals(1, session('cart')['BRG002']);

        // Buka keranjang
        $response = $this->actingAs($user)->get('/keranjang');
        $response->assertStatus(200);
        $response->assertSee('Mouse Wireless Logitech');

        // Laptop BRG001 stok 5, coba set cart ke 5 lalu tambah lagi
        $this->withSession(['cart' => ['BRG001' => 5]]);
        $response = $this->actingAs($user)->get('/keranjang/tambah-qty/BRG001');
        $response->assertSessionHas('error');
        $this->assertEquals(5, session('cart')['BRG001']); // Tidak boleh jadi 6
    }

    public function test_checkout_berhasil_mengurangi_stok_dan_mengosongkan_keranjang(): void
    {
        $user = User::where('username', 'budi')->first();
        $product = Product::find('BRG002'); // Stok awal 20, harga 150.000
        $stokAwal = $product->stok;

        // Beli 2 unit mouse
        $response = $this->actingAs($user)
            ->withSession(['cart' => ['BRG002' => 2]])
            ->post('/checkout', [
                'alamat_pengiriman' => 'Jl. Kebon Jeruk No. 8, Jakarta',
            ]);

        $response->assertRedirect('/pesanan');
        $response->assertSessionHas('success');

        // Pastikan keranjang kosong
        $this->assertEmpty(session('cart', []));

        // Pastikan stok berkurang 2
        $product->refresh();
        $this->assertEquals($stokAwal - 2, $product->stok);

        // Pastikan pesanan tersimpan di database
        $this->assertDatabaseHas('orders', [
            'id_user' => $user->id_user,
            'total_harga' => 300000,
            'alamat_pengiriman' => 'Jl. Kebon Jeruk No. 8, Jakarta',
        ]);

        $this->assertDatabaseHas('order_details', [
            'id_barang' => 'BRG002',
            'harga_satuan' => 150000,
            'jumlah_beli' => 2,
        ]);
    }

    public function test_riwayat_pesanan_menampilkan_pesanan(): void
    {
        $user = User::where('username', 'budi')->first();

        // Checkout 1 barang
        $this->actingAs($user)
            ->withSession(['cart' => ['BRG003' => 1]])
            ->post('/checkout', [
                'alamat_pengiriman' => 'Alamat Uji',
            ]);

        $response = $this->actingAs($user)->get('/pesanan');
        $response->assertStatus(200);
        $response->assertSee('Keyboard Mechanical RGB');
    }
}
