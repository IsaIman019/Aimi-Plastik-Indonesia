<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class General extends Model
{
    protected $table = 'general';
    protected $guarded = ['id'];

    public function variants()
    {
        return $this->hasMany(Produk::class);
    }
}
