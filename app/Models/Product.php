<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $primaryKey = 'id';

    public $incrementing = true;
    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
        'image',
        'barcode',
        'price',
        'purchase_price',
        'quantity',
        'status',
    ];

    protected $casts = [
        'price' => 'integer',
        'purchase_price' => 'integer',
        'quantity' => 'integer',
        'status' => 'integer',
    ];

    public function scopeLowStock($query)
    {
        return $query->where('quantity', '<=', 5);
    }

    public function scopeBestSelling($query)
    {
        return $query->orderBy('quantity', 'desc');
    }

    public function scopeCurrentMonthBestSelling($query)
    {
        return $query->whereMonth('created_at', now()->month)
            ->orderBy('quantity', 'desc');
    }

    public function scopePastMonthsHotProducts($query)
    {
        return $query->where('created_at', '<', now()->startOfMonth())
            ->orderBy('quantity', 'desc');
    }

    public function getImageUrlAttribute()
    {
        if (empty($this->image)) {
            return asset('images/img-placeholder.jpg');
        }

        if (
            str_starts_with($this->image, 'http://') ||
            str_starts_with($this->image, 'https://')
        ) {
            return $this->image;
        }

        return asset('products/' . $this->image);
    }
}
