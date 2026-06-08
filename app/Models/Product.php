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
