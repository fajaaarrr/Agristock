<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IncomingGoods extends Model
{
    use HasFactory;

    protected $table = 'incoming_goods';

    protected $fillable = [
        'nomor_transaksi',
        'item_id',
        'tanggal_masuk',
        'jumlah',
        'supplier',
        'keterangan',
    ];

    /**
     * Get the item associated with the transaction.
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
