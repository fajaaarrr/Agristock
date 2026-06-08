<?php

namespace App\Services;

use App\Models\OutgoingGoods;
use App\Models\Item;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Exception;

class OutgoingGoodsService
{
    /**
     * Get paginated outgoing goods list with search.
     */
    public function getPaginated(string $search = '', int $perPage = 10): LengthAwarePaginator
    {
        $query = OutgoingGoods::with('item');

        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('nomor_transaksi', 'like', "%{$search}%")
                  ->orWhere('tujuan_penggunaan', 'like', "%{$search}%")
                  ->orWhereHas('item', function($itemQuery) use ($search) {
                      $itemQuery->where('nama_barang', 'like', "%{$search}%")
                                ->orWhere('kode_barang', 'like', "%{$search}%");
                  });
            });
        }

        return $query->latest('tanggal_keluar')->paginate($perPage)->withQueryString();
    }

    /**
     * Create an outgoing goods transaction and update item stock.
     * Throws exception if stock is insufficient.
     */
    public function create(array $data): OutgoingGoods
    {
        return DB::transaction(function() use ($data) {
            $item = Item::findOrFail($data['item_id']);

            // Validate that we don't issue more than available stock
            if ($item->stok < $data['jumlah']) {
                throw new Exception("Stok tidak mencukupi. Stok saat ini untuk {$item->nama_barang} adalah {$item->stok} {$item->satuan}.");
            }

            // Create outgoing goods transaction
            $outgoing = OutgoingGoods::create($data);

            // Decrement the item stock
            $item->decrement('stok', $data['jumlah']);

            return $outgoing;
        });
    }

    /**
     * Delete an outgoing goods transaction and revert item stock.
     */
    public function delete(OutgoingGoods $outgoingGoods): bool
    {
        return DB::transaction(function() use ($outgoingGoods) {
            // Revert stock (add what was subtracted)
            $item = $outgoingGoods->item;
            $item->increment('stok', $outgoingGoods->jumlah);

            // Delete transaction record
            return $outgoingGoods->delete();
        });
    }
}
