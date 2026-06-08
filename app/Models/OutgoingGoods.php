<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OutgoingGoods extends Model
{
    use HasFactory;

    protected $table = 'outgoing_goods';

    protected $fillable = [
        'nomor_transaksi',
        'item_id',
        'tanggal_keluar',
        'jumlah',
        'tujuan_penggunaan',
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
