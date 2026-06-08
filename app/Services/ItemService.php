<?php

namespace App\Services;

use App\Models\Item;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ItemService
{
    /**
     * Get paginated, searched, and category-filtered items.
     */
    public function getPaginated(string $search = '', ?int $categoryId = null, int $perPage = 10): LengthAwarePaginator
    {
        $query = Item::with('category');

        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('kode_barang', 'like', "%{$search}%")
                  ->orWhere('lokasi_rak', 'like', "%{$search}%");
            });
        }

        if ($categoryId !== null) {
            $query->where('category_id', $categoryId);
        }

        return $query->latest()->paginate($perPage)->withQueryString();
    }

    /**
     * Get all items.
     */
    public function getAll(): Collection
    {
        return Item::orderBy('nama_barang')->get();
    }

    /**
     * Create a new item.
     */
    public function create(array $data): Item
    {
        return Item::create($data);
    }

    /**
     * Update an item.
     */
    public function update(Item $item, array $data): Item
    {
        $item->update($data);
        return $item;
    }

    /**
     * Delete an item.
     */
    public function delete(Item $item): bool
    {
        return $item->delete();
    }

    /**
     * Get low stock items.
     */
    public function getLowStockItems(): Collection
    {
        return Item::with('category')->lowStock()->get();
    }
}
