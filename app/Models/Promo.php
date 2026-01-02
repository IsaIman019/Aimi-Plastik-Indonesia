<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    /**
     * Kolom yang bisa diisi (Sesuai dengan Migration sebelumnya)
     */
    protected $fillable = [
        'name',       // Nama Promo (misal: Flash Sale)
        'type',       // Tipe: 'percent' atau 'fixed'
        'value',      // Nilai diskon
        'start_date',
        'end_date',
        'is_active',
    ];

    /**
     * Konversi otomatis tipe data tanggal
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'is_active'  => 'boolean',
    ];

    /**
     * Relasi Many-to-Many ke Produk
     * (Satu promo bisa dimiliki banyak produk)
     */
    public function products()
    {
        // Menggunakan tabel pivot 'product_promo'
        return $this->belongsToMany(Product::class, 'product_promo');
    }
}