<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $purchase_id
 * @property int $raw_material_id
 * @property int $quantity
 * @property numeric $purchase_price Price at time of purchase
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read float $subtotal
 * @property-read \App\Models\RawMaterial $rawMaterial
 * @property-read \App\Models\Purchase $purchase
 */
class PurchaseItem extends Model
{
    protected $fillable = [
        'purchase_id',
        'raw_material_id',
        'quantity',
        'purchase_price',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'purchase_price' => 'decimal:2',
        ];
    }

    public function rawMaterial(): BelongsTo
    {
        return $this->belongsTo(related: RawMaterial::class, foreignKey: 'raw_material_id');
    }

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(related: Purchase::class, foreignKey: 'purchase_id');
    }

    public function getSubtotalAttribute(): float
    {
        return (float) ($this->quantity * $this->purchase_price);
    }
}