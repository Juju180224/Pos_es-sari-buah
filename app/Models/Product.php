<?php

namespace App\Models;

use App\Traits\ProductScopes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id_produk
 * @property string $nama_produk
 * @property string|null $gambar
 * @property string $kode_produk
 * @property numeric $harga_jual
 * @property int $stok
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string $image_url
 * @mixin \Eloquent
 */
class Product extends Model
{
    use HasFactory;
    use ProductScopes;

    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    protected $table = 'produk';

    protected $primaryKey = 'id_produk';

    public $incrementing = true;

    protected $keyType = 'int';

    /*
    |--------------------------------------------------------------------------
    | FILLABLE
    |--------------------------------------------------------------------------
    */

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
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'harga_jual' => 'decimal:2',
        'stok' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | APPENDS
    |--------------------------------------------------------------------------
    */

    protected $appends = [
        'image_url'
    ];

    /*
    |--------------------------------------------------------------------------
    | ATTRIBUTE MAPPING
    |--------------------------------------------------------------------------
    */

    // AGAR $product->name BISA DIPAKAI
    public function getNameAttribute()
    {
        return $this->nama_produk;
    }

    // AGAR $product->image BISA DIPAKAI
    public function getImageAttribute()
    {
        return $this->gambar;
    }

    // AGAR $product->price BISA DIPAKAI
    public function getPriceAttribute()
    {
        return $this->harga_jual;
    }

    // AGAR $product->quantity BISA DIPAKAI
    public function getQuantityAttribute()
    {
        return $this->stok;
    }

    // AGAR $product->barcode BISA DIPAKAI
    public function getBarcodeAttribute()
    {
        return $this->kode_produk;
    }

    /*
    |--------------------------------------------------------------------------
    | IMAGE URL
    |--------------------------------------------------------------------------
    */

    public function getImageUrlAttribute(): string
    {
        if ($this->gambar) {

            return asset('products/' . $this->gambar);
        }

        return asset('images/img-placeholder.jpg');
    }


    /*
|--------------------------------------------------------------------------
| SCOPES
|--------------------------------------------------------------------------
*/

    public function scopeSearch(Builder $query, ?string $term): Builder
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
