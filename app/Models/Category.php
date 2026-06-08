<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    /**
     * Get the items for this category.
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class, 'category_id');
    }
}
