<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjang';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Produk::class);
    }

    public function subtotal()
    {
        return $this->qty * $this->product->harga;
    }
    public function pesanandetail()
    {
        return $this->belongsTo(PesananDetail::class);
    }
}
