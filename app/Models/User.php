<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Address; // <--- 1. PASTIKAN INI ADA

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'avatar',
        'address', // (Opsional) Alamat lama
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // =========================================================
    // 2. FUNGSI RELASI INI WAJIB ADA AGAR TIDAK ERROR NULL
    // =========================================================
    public function addresses()
    {
        return $this->hasMany(Address::class)->orderBy('is_primary', 'desc');
    }
}