<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'price',
        'quantity',
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'price' => 'float',
        'quantity' => 'integer',
    ];

    /**
     * ========================
     * RELATIONSHIPS
     * ========================
     */

    /**
     * Relasi ke Order
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    /**
     * Relasi ke Product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id')
            ->withDefault([
                'name' => 'Produk dihapus'
            ]);
    }

    /**
     * ========================
     * BUSINESS LOGIC
     * ========================
     */

    /**
     * Subtotal item (price × quantity)
     */
    public function subtotal(): float
    {
        return (float) ($this->price * $this->quantity);
    }

    /**
     * Harga satuan (unit price)
     */
    public function unitPrice(): float
    {
        return (float) $this->price;
    }

    /**
     * ========================
     * FORMAT HELPER (VIEW)
     * ========================
     */

    /**
     * Format harga satuan
     */
    public function formattedPrice(): string
    {
        return number_format($this->price, 0, ',', '.');
    }

    /**
     * Format subtotal
     */
    public function formattedSubtotal(): string
    {
        return number_format($this->subtotal(), 0, ',', '.');
    }
}
