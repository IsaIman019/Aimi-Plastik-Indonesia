<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'label', 'recipient_name', 'phone', 'full_address', 'is_primary'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function addresses()
{
    return $this->hasMany(Address::class)->orderBy('is_primary', 'desc');
}
}