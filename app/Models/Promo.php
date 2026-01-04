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
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai'   => 'datetime',
    ];


    public function produk()
    {
        return $this->belongsToMany(Produk::class, 'product_promo');
    }
}