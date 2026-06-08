<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Item;
use App\Models\IncomingGoods;
use App\Models\OutgoingGoods;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AgriStockTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        // Create the admin user
        $this->admin = User::create([
            'name' => 'Admin Gudang Test',
            'email' => 'admin@test.com',
            'password' => Hash::make('password')
        ]);

        // Create a test category
        $this->category = Category::create([
            'nama_kategori' => 'Pupuk Utama',
            'deskripsi' => 'Kategori pupuk utama'
        ]);
    }

    /**
     * Test guest users are redirected to login.
     */
    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/dashboard');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Test admin login.
     */
    public function test_admin_can_login_with_correct_credentials(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@test.com',
            'password' => 'password'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($this->admin);
    }

    /**
     * Test category CRUD.
     */
    public function test_category_crud_operations(): void
    {
        $this->actingAs($this->admin);

        // 1. Create
        $response = $this->post('/categories', [
            'nama_kategori' => 'Benih Baru',
            'deskripsi' => 'Benih padi'
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('categories', ['nama_kategori' => 'Benih Baru']);

        $category = Category::where('nama_kategori', 'Benih Baru')->first();

        // 2. Update
        $response = $this->put("/categories/{$category->id}", [
            'nama_kategori' => 'Benih Unggul',
            'deskripsi' => 'Benih unggul padi'
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('categories', ['nama_kategori' => 'Benih Unggul']);

        // 3. Delete
        $response = $this->delete("/categories/{$category->id}");
        $response->assertStatus(302);
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    /**
     * Test item CRUD.
     */
    public function test_item_crud_operations(): void
    {
        $this->actingAs($this->admin);

        // 1. Create
        $response = $this->post('/items', [
            'kode_barang' => 'BRG-001',
            'nama_barang' => 'Urea Cap Daun',
            'category_id' => $this->category->id,
            'satuan' => 'Bag',
            'stok' => 10,
            'stok_minimum' => 5,
            'lokasi_rak' => 'Rak A1',
            'deskripsi' => 'Pupuk urea subsidi'
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('items', ['kode_barang' => 'BRG-001']);

        $item = Item::where('kode_barang', 'BRG-001')->first();

        // 2. Update
        $response = $this->put("/items/{$item->id}", [
            'kode_barang' => 'BRG-001-EDITED',
            'nama_barang' => 'Urea Cap Daun Super',
            'category_id' => $this->category->id,
            'satuan' => 'Bag (50kg)',
            'stok' => 12,
            'stok_minimum' => 6,
            'lokasi_rak' => 'Rak A2',
            'deskripsi' => 'Pupuk urea non-subsidi'
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('items', ['kode_barang' => 'BRG-001-EDITED', 'stok' => 12]);

        // 3. Delete
        $response = $this->delete("/items/{$item->id}");
        $response->assertStatus(302);
        $this->assertDatabaseMissing('items', ['id' => $item->id]);
    }

    /**
     * Test incoming goods stock changes.
     */
    public function test_incoming_goods_increments_and_deleting_decrements_stock(): void
    {
        $this->actingAs($this->admin);

        // Create an item with stock 10
        $item = Item::create([
            'kode_barang' => 'BRG-INC',
            'nama_barang' => 'Urea Test',
            'category_id' => $this->category->id,
            'satuan' => 'Bag',
            'stok' => 10,
            'stok_minimum' => 5
        ]);

        // Post incoming transaction +5
        $response = $this->post('/incoming-goods', [
            'nomor_transaksi' => 'IN-TEST-001',
            'item_id' => $item->id,
            'tanggal_masuk' => '2026-06-07',
            'jumlah' => 5,
            'supplier' => 'PT Sriwijaya',
            'keterangan' => 'Uji Coba Masuk'
        ]);
        $response->assertStatus(302);

        // Stock should now be 15
        $item->refresh();
        $this->assertEquals(15, $item->stok);
        $this->assertDatabaseHas('incoming_goods', ['nomor_transaksi' => 'IN-TEST-001']);

        // Delete incoming transaction
        $incoming = IncomingGoods::where('nomor_transaksi', 'IN-TEST-001')->first();
        $response = $this->delete("/incoming-goods/{$incoming->id}");
        $response->assertStatus(302);

        // Stock should revert back to 10
        $item->refresh();
        $this->assertEquals(10, $item->stok);
        $this->assertDatabaseMissing('incoming_goods', ['id' => $incoming->id]);
    }

    /**
     * Test outgoing goods stock changes.
     */
    public function test_outgoing_goods_decrements_and_deleting_increments_stock(): void
    {
        $this->actingAs($this->admin);

        // Create an item with stock 10
        $item = Item::create([
            'kode_barang' => 'BRG-OUT',
            'nama_barang' => 'Benih Test',
            'category_id' => $this->category->id,
            'satuan' => 'Kg',
            'stok' => 10,
            'stok_minimum' => 3
        ]);

        // Post outgoing transaction -3
        $response = $this->post('/outgoing-goods', [
            'nomor_transaksi' => 'OUT-TEST-001',
            'item_id' => $item->id,
            'tanggal_keluar' => '2026-06-07',
            'jumlah' => 3,
            'tujuan_penggunaan' => 'Lahan Karawang',
            'keterangan' => 'Uji Coba Keluar'
        ]);
        $response->assertStatus(302);

        // Stock should now be 7
        $item->refresh();
        $this->assertEquals(7, $item->stok);
        $this->assertDatabaseHas('outgoing_goods', ['nomor_transaksi' => 'OUT-TEST-001']);

        // Delete outgoing transaction
        $outgoing = OutgoingGoods::where('nomor_transaksi', 'OUT-TEST-001')->first();
        $response = $this->delete("/outgoing-goods/{$outgoing->id}");
        $response->assertStatus(302);

        // Stock should revert back to 10
        $item->refresh();
        $this->assertEquals(10, $item->stok);
        $this->assertDatabaseMissing('outgoing_goods', ['id' => $outgoing->id]);
    }

    /**
     * Test outgoing goods cannot exceed available stock.
     */
    public function test_outgoing_goods_cannot_exceed_available_stock(): void
    {
        $this->actingAs($this->admin);

        // Create an item with stock 5
        $item = Item::create([
            'kode_barang' => 'BRG-LIMIT',
            'nama_barang' => 'Pestisida Test',
            'category_id' => $this->category->id,
            'satuan' => 'Liter',
            'stok' => 5,
            'stok_minimum' => 1
        ]);

        // Attempt to issue 6 items (exceeds stock of 5)
        $response = $this->post('/outgoing-goods', [
            'nomor_transaksi' => 'OUT-LIMIT-001',
            'item_id' => $item->id,
            'tanggal_keluar' => '2026-06-07',
            'jumlah' => 6,
            'tujuan_penggunaan' => 'Lahan Sukabumi',
            'keterangan' => 'Uji Coba Gagal'
        ]);

        // Should return back with error redirect session
        $response->assertStatus(302);
        $response->assertSessionHas('error');
        
        // Stock should remain 5
        $item->refresh();
        $this->assertEquals(5, $item->stok);
        $this->assertDatabaseMissing('outgoing_goods', ['nomor_transaksi' => 'OUT-LIMIT-001']);
    }
}
