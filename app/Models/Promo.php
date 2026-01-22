<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $table = 'promo';
    protected $guarded = ['id'];

    protected $casts = [
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
        'is_all_product'  => 'boolean',
        'jumlah' => 'float',
    ];

    public function produks()
    {
        return $this->belongsToMany(
            Produk::class,
            'promo_produk',
            'promo_id',
            'produk_id'
        );
    }

}