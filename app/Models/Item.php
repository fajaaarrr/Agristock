<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'category_id',
        'satuan',
        'stok',
        'stok_minimum',
        'lokasi_rak',
        'deskripsi',
    ];

    /**
     * Get the category that owns this item.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Get the incoming goods transactions for this item.
     */
    public function incomingGoods(): HasMany
    {
        return $this->hasMany(IncomingGoods::class, 'item_id');
    }

    /**
     * Get the outgoing goods transactions for this item.
     */
    public function outgoingGoods(): HasMany
    {
        return $this->hasMany(OutgoingGoods::class, 'item_id');
    }

    /**
     * Scope a query to only include low stock items.
     */
    public function scopeLowStock(Builder $query): Builder
    {
        return $query->whereColumn('stok', '<=', 'stok_minimum');
    }

    /**
     * Accessor to check if item is currently low in stock.
     */
    public function getIsLowStockAttribute(): bool
    {
        return $this->stok <= $this->stok_minimum;
    }
}
