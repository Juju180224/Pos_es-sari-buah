<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'unit',
        'stock',
        'purchase_price',
        'low_stock_threshold',
    ];

    protected function casts(): array
    {
        return [
            'stock' => 'decimal:2',
            'purchase_price' => 'decimal:2',
            'low_stock_threshold' => 'decimal:2',
        ];
    }

    /**
     * Cek apakah stok berada di bawah batas minimum.
     */
    public function isLowStock(): bool
    {
        return $this->stock <= $this->low_stock_threshold;
    }
}