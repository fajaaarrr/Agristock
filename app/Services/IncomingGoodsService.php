<?php

namespace App\Services;

use App\Models\IncomingGoods;
use App\Models\Item;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class IncomingGoodsService
{
    /**
     * Get paginated incoming goods list with search.
     */
    public function getPaginated(string $search = '', int $perPage = 10): LengthAwarePaginator
    {
        $query = IncomingGoods::with('item');

        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('nomor_transaksi', 'like', "%{$search}%")
                  ->orWhere('supplier', 'like', "%{$search}%")
                  ->orWhereHas('item', function($itemQuery) use ($search) {
                      $itemQuery->where('nama_barang', 'like', "%{$search}%")
                                ->orWhere('kode_barang', 'like', "%{$search}%");
                  });
            });
        }

        return $query->latest('tanggal_masuk')->paginate($perPage)->withQueryString();
    }

    /**
     * Create an incoming goods transaction and update item stock.
     */
    public function create(array $data): IncomingGoods
    {
        return DB::transaction(function() use ($data) {
            // Create incoming goods transaction
            $incoming = IncomingGoods::create($data);

            // Increment the item stock
            $item = Item::findOrFail($data['item_id']);
            $item->increment('stok', $data['jumlah']);

            return $incoming;
        });
    }

    /**
     * Delete an incoming goods transaction and revert item stock.
     */
    public function delete(IncomingGoods $incomingGoods): bool
    {
        return DB::transaction(function() use ($incomingGoods) {
            // Revert stock (subtract what was added)
            $item = $incomingGoods->item;
            $item->decrement('stok', $incomingGoods->jumlah);

            // Delete transaction record
            return $incomingGoods->delete();
        });
    }
}
