<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $fillable = [
        'nama',
        'deskripsi',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Scope untuk status aktif
    public function scopeActive($query)
    {
        return $query->where('status', 'ACTIVE');
    }

    // Scope untuk pencarian
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%");
        });
    }

    /**
     * Get the articles for the category
     */
    public function articles()
    {
        return $this->hasMany(Artikel::class, 'kategori_id');
    }

    /**
     * Alias untuk articles (jika ada kode yang memanggil artikel())
     */
    public function artikel()
    {
        return $this->hasMany(Artikel::class, 'kategori_id');
    }

    public function produk()
    {
        return $this->hasMany(Produk::class);
    }
}