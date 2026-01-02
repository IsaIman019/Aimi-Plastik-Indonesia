<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; // <--- PENTING: Import Carbon untuk cek tanggal promo

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'description',
        'price',
        'stock',
        'image',
        'is_active',
        'is_featured',
    ];

    /**
     * Relasi ke Kategori
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // =================================================================
    // UPDATE: LOGIKA PROMO & DISKON
    // =================================================================

    /**
     * 1. Relasi Many-to-Many ke Tabel Promo
     */
    public function promos()
    {
        return $this->belongsToMany(Promo::class, 'product_promo');
    }

    /**
     * 2. Accessor: Cek apakah ada promo yang AKTIF HARI INI
     * Cara panggil: $product->active_promo
     */
    public function getActivePromoAttribute()
    {
        return $this->promos()
            ->where('is_active', true)
            ->whereDate('start_date', '<=', Carbon::now()) // Sudah mulai
            ->whereDate('end_date', '>=', Carbon::now())   // Belum berakhir
            ->orderBy('value', 'desc') // Jika ada 2 promo, ambil diskon terbesar
            ->first();
    }

    /**
     * 3. Accessor: Hitung Harga Akhir (Harga Asli - Diskon)
     * Cara panggil: $product->final_price
     */
    public function getFinalPriceAttribute()
    {
        $promo = $this->active_promo;

        if ($promo) {
            if ($promo->type == 'percent') {
                // Rumus Persen: Harga - (Harga * % / 100)
                $discount = $this->price * ($promo->value / 100);
                return $this->price - $discount;
            } else {
                // Rumus Potongan Tetap: Harga - Nominal
                return max($this->price - $promo->value, 0); // Harga tidak boleh minus
            }
        }

        // Jika tidak ada promo, kembalikan harga asli
        return $this->price;
    }
}