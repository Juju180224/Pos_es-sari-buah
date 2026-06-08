<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = 'produk';


    protected $primaryKey = 'id_produk';


    public $incrementing = true;


    protected $keyType = 'int';


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
        'id_satuan',
    ];


    protected $casts = [
        'harga_beli' => 'integer',
        'harga_jual' => 'integer',
        'stok' => 'integer',
        'stok_minimal' => 'integer',
        'diskon' => 'integer',
    ];


    public function getImageUrlAttribute()
    {
        if (empty($this->gambar)) {
            return asset('images/img-placeholder.jpg');
        }

        if (
            str_starts_with($this->gambar, 'http://') ||
            str_starts_with($this->gambar, 'https://')
        ) {
            return $this->gambar;
        }

        return asset('products/' . $this->gambar);
    }
}
