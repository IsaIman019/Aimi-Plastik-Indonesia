<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'product_id',
        'quantity',
        'min_stock'
    ];

    /* =====================
     | RELATIONSHIPS
     ===================== */

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /* =====================
     | HELPER
     ===================== */

    public function isLowStock()
    {
        return $this->quantity <= $this->min_stock;
    }
}
