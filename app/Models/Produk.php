<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; // <--- PENTING: Import Carbon untuk cek tanggal promo

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $guarded = ['id'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
    public function varian()
    {
        return $this->belongsTo(General::class);
    }

    // public function promos()
    // {
    //     return $this->belongsToMany(Promo::class, 'product_promo');
    // }

    // public function getActivePromoAttribute()
    // {
    //     return $this->promos()
    //         ->where('is_active', true)
    //         ->whereDate('start_date', '<=', Carbon::now()) 
    //         ->whereDate('end_date', '>=', Carbon::now())  
    //         ->orderBy('value', 'desc')
    //         ->first();
    // }

    // public function getFinalPriceAttribute()
    // {
    //     $promo = $this->active_promo;

    //     if ($promo) {
    //         if ($promo->type == 'percent') {
    //             $discount = $this->price * ($promo->value / 100);
    //             return $this->price - $discount;
    //         } else {
    //             return max($this->price - $promo->value, 0); // Harga tidak boleh minus
    //         }
    //     }

    //     return $this->price;
    // }
}