<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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

    public function scopeSearch(Builder $query, ?string $keyword): Builder
    {
        return $query->when($keyword, function ($q) use ($keyword) {
            $q->where('name', 'like', "%{$keyword}%")
                ->orWhere('barcode', 'like', "%{$keyword}%");
        });
    }
    public function scopeLowStock(Builder $query): Builder
    {
        return $query->where('quantity', '<=', 5);
    }

    public function scopeBestSelling(Builder $query): Builder
    {
        return $query->orderBy('quantity', 'desc');
    }
    public function scopeCurrentMonthBestSelling(Builder $query): Builder
    {
        return $query->whereMonth('created_at', now()->month)
            ->orderBy('quantity', 'desc');
    }

    public function scopePastMonthsHotProducts(Builder $query): Builder
    {
        return $query->where('created_at', '<', now()->startOfMonth())
            ->orderBy('quantity', 'desc');
    }

    public function getImagePathAttribute()
    {
        if (empty($this->image)) {
            return null;
        }

        $path = ltrim($this->image, '/');

        if (str_starts_with($path, 'storage/')) {
            $path = ltrim(substr($path, strlen('storage/')), '/');
        }

        if (str_starts_with($path, 'public/')) {
            $path = ltrim(substr($path, strlen('public/')), '/');
        }

        if (!str_contains($path, '/')) {
            $path = 'products/' . $path;
        }

        return $path;
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/img-placeholder.jpg');
        }


        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }

        return asset('storage/' . $this->image);
    }
}
