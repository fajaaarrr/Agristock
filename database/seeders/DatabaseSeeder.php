<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use App\Models\IncomingGoods;
use App\Models\OutgoingGoods;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin User
        User::create([
            'name' => 'Admin Gudang AgriStock',
            'email' => 'admin@agristock.com',
            'password' => Hash::make('password'),
        ]);

        // 2. Categories
        $categories = [
            ['nama_kategori' => 'Pupuk', 'deskripsi' => 'Bahan penyedia unsur hara tanaman untuk meningkatkan produksi pertanian.'],
            ['nama_kategori' => 'Benih', 'deskripsi' => 'Biji tanaman unggulan yang disiapkan untuk penanaman.'],
            ['nama_kategori' => 'Pestisida', 'deskripsi' => 'Bahan kimia pembasmi hama atau organisme pengganggu tanaman.'],
            ['nama_kategori' => 'Alat Pertanian', 'deskripsi' => 'Peralatan mekanik maupun manual pendukung pengerjaan lahan.'],
            ['nama_kategori' => 'Hasil Panen', 'deskripsi' => 'Komoditas hasil pertanian yang dikumpulkan dari perkebunan/lahan.'],
        ];

        $categoryModels = [];
        foreach ($categories as $cat) {
            $categoryModels[$cat['nama_kategori']] = Category::create($cat);
        }

        // 3. Items
        $items = [
            [
                'kode_barang' => 'BRG-PUP-001',
                'nama_barang' => 'Pupuk Urea Kaltim',
                'category_id' => $categoryModels['Pupuk']->id,
                'satuan' => 'Bag (50kg)',
                'stok' => 150,
                'stok_minimum' => 50,
                'lokasi_rak' => 'Rak A-1',
                'deskripsi' => 'Pupuk nitrogen berkualitas tinggi dari Kaltim.',
            ],
            [
                'kode_barang' => 'BRG-PUP-002',
                'nama_barang' => 'Pupuk NPK Mutiara 16-16-16',
                'category_id' => $categoryModels['Pupuk']->id,
                'satuan' => 'Bag (50kg)',
                'stok' => 20,
                'stok_minimum' => 40,
                'lokasi_rak' => 'Rak A-2',
                'deskripsi' => 'Pupuk majemuk untuk nutrisi seimbang tanaman hortikultura.',
            ],
            [
                'kode_barang' => 'BRG-BEN-001',
                'nama_barang' => 'Benih Padi Ciherang',
                'category_id' => $categoryModels['Benih']->id,
                'satuan' => 'Kg',
                'stok' => 250,
                'stok_minimum' => 100,
                'lokasi_rak' => 'Rak B-1',
                'deskripsi' => 'Benih padi varietas unggul Ciherang kemasan 5kg.',
            ],
            [
                'kode_barang' => 'BRG-BEN-002',
                'nama_barang' => 'Benih Jagung Hibrida Pioneer P35',
                'category_id' => $categoryModels['Benih']->id,
                'satuan' => 'Kg',
                'stok' => 15,
                'stok_minimum' => 30,
                'lokasi_rak' => 'Rak B-2',
                'deskripsi' => 'Benih jagung hibrida tahan kekeringan.',
            ],
            [
                'kode_barang' => 'BRG-PES-001',
                'nama_barang' => 'Pestisida RoundUp 486 SL',
                'category_id' => $categoryModels['Pestisida']->id,
                'satuan' => 'Liter',
                'stok' => 85,
                'stok_minimum' => 20,
                'lokasi_rak' => 'Rak C-1',
                'deskripsi' => 'Herbisida sistemik purna tumbuh untuk mengendalikan gulma.',
            ],
            [
                'kode_barang' => 'BRG-ALA-001',
                'nama_barang' => 'Cangkul Baja Cap Buaya',
                'category_id' => $categoryModels['Alat Pertanian']->id,
                'satuan' => 'Pcs',
                'stok' => 10,
                'stok_minimum' => 15,
                'lokasi_rak' => 'Rak D-1',
                'deskripsi' => 'Cangkul baja kuat untuk pengolahan tanah.',
            ],
            [
                'kode_barang' => 'BRG-ALA-002',
                'nama_barang' => 'Traktor Tangan Kubota G1000',
                'category_id' => $categoryModels['Alat Pertanian']->id,
                'satuan' => 'Unit',
                'stok' => 3,
                'stok_minimum' => 1,
                'lokasi_rak' => 'Gudang Belakang',
                'deskripsi' => 'Traktor tangan bajak sawah bermesin diesel.',
            ],
            [
                'kode_barang' => 'BRG-PAN-001',
                'nama_barang' => 'Beras Pandan Wangi Cianjur',
                'category_id' => $categoryModels['Hasil Panen']->id,
                'satuan' => 'Kg',
                'stok' => 1200,
                'stok_minimum' => 500,
                'lokasi_rak' => 'Gudang Utama',
                'deskripsi' => 'Beras aromatik pandan wangi Cianjur.',
            ],
        ];

        $itemModels = [];
        foreach ($items as $itemData) {
            $itemModels[$itemData['kode_barang']] = Item::create($itemData);
        }

        // 4. Seeding transactions (to populate charts)
        // Add incoming transactions (note: stocks in items table are already updated, this is just for matching initial records)
        IncomingGoods::create([
            'nomor_transaksi' => 'IN-20260601-001',
            'item_id' => $itemModels['BRG-PUP-001']->id,
            'tanggal_masuk' => '2026-06-01',
            'jumlah' => 100,
            'supplier' => 'PT Pupuk Sriwidjaja',
            'keterangan' => 'Pengadaan awal bulan Juni.',
        ]);

        IncomingGoods::create([
            'nomor_transaksi' => 'IN-20260602-002',
            'item_id' => $itemModels['BRG-BEN-001']->id,
            'tanggal_masuk' => '2026-06-02',
            'jumlah' => 150,
            'supplier' => 'PT Sang Hyang Seri',
            'keterangan' => 'Pasokan benih padi unggul.',
        ]);

        // Add outgoing transactions
        OutgoingGoods::create([
            'nomor_transaksi' => 'OUT-20260603-001',
            'item_id' => $itemModels['BRG-PUP-001']->id,
            'tanggal_keluar' => '2026-06-03',
            'jumlah' => 20,
            'tujuan_penggunaan' => 'Kelompok Tani Jaya Makmur',
            'keterangan' => 'Distribusi pupuk subsidi.',
        ]);

        OutgoingGoods::create([
            'nomor_transaksi' => 'OUT-20260604-002',
            'item_id' => $itemModels['BRG-BEN-001']->id,
            'tanggal_keluar' => '2026-06-04',
            'jumlah' => 30,
            'tujuan_penggunaan' => 'Subang Demonstration Plot',
            'keterangan' => 'Uji coba penanaman kluster baru.',
        ]);
    }
}
