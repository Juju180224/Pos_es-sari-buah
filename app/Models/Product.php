<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $primaryKey = 'id_produk';

    public $timestamps = true;

    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'gambar',
        'merk',
        'harga_beli',
        'diskon',
        'harga_jual',
        'stok',
        'stok_minimal',
        'id_kategori',
        'id_satuan'
    ];

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR
    |--------------------------------------------------------------------------
    */

    public function getIdAttribute()
    {
        return $this->id_produk;
    }

    public function getNameAttribute()
    {
        return $this->nama_produk;
    }

    public function getImageAttribute()
    {
        return $this->gambar;
    }

    public function getPriceAttribute()
    {
        return $this->harga_jual;
    }

    public function getQuantityAttribute()
    {
        return $this->stok;
    }

    public function getBarcodeAttribute()
    {
        return $this->kode_produk;
    }

    public function getImageUrlAttribute()
    {
        if ($this->gambar) {

            return asset('products/' . $this->gambar);
        }

        return asset('images/img-placeholder.jpg');
    }

    /*
    |--------------------------------------------------------------------------
    | SEARCH
    |--------------------------------------------------------------------------
    */

    public function scopeSearch(Builder $query, $term)
    {
        if ($term) {

            $query->where(
                'nama_produk',
                'LIKE',
                '%' . $term . '%'
            );
        }

        return $query;
    }
}
