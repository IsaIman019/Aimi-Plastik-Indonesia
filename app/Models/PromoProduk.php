<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoProduk extends Model
{
    use HasFactory;
    protected $table = 'promo_produk';
    protected $guarded = ['id'];
}
