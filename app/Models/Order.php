<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'subtotal',
        'discount',
        'total',
        'status',
        'payment_method',
        'midtrans_order_id'
    ];

    /* =====================
     | RELATIONSHIPS
     ===================== */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /* =====================
     | HELPER METHOD
     ===================== */

    public function isPaid()
    {
        return $this->status === 'paid';
    }
}
