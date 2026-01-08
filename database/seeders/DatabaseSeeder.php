<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Produk;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Admin & Pelanggan
        User::create([
            'nama' => 'Admin Aimi',
            'email' => 'admin@aimi.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
        ]);

        User::create([
            'nama' => 'Pelanggan Setia',
            'email' => 'user@aimi.com',
            'password' => Hash::make('password'),
            'role' => 'pelanggan',
            'phone' => '08987654321',
        ]);

        // // 2. Buat Kategori
        // $catLakban = Kategori::create(['nama' => 'Lakban & Perekat', 'slug' => 'lakban-perekat']);
        // $catPlastik = Kategori::create(['nama' => 'Plastik & Bubble', 'slug' => 'plastik-bubble']);
        // $catAmplop = Kategori::create(['nama' => 'Amplop & Mailer', 'slug' => 'amplop-mailer']);

        // // 3. Buat Produk Real (Sesuai Gambar)

        // // Produk 1: Lakban Bening 72pcs
        // Produk::create([
        //     'Kategori_id' => $catLakban->id,
        //     'nama' => 'Lakban Bening Daimaru (Dus isi 72 Pcs)',
        //     'slug' => 'lakban-bening-72-pcs',
        //     'description' => 'Lakban bening kualitas premium daya rekat kuat. Cocok untuk packing kardus standar. Harga grosir 1 dus isi 72 roll.',
        //     'price' => 650000,
        //     'stock' => 50,
        //     'is_active' => true,
        //     'is_featured' => true, // Tampil di Beranda
        //     'image' => 'images/Produk/lakban-bening-72.jpg' // Path gambar
        // ]);

        // // Produk 2: Lakban Fragile 72pcs
        // Produk::create([
        //     'Kategori_id' => $catLakban->id,
        //     'nama' => 'Lakban Fragile Merah (Dus isi 72 Pcs)',
        //     'slug' => 'lakban-fragile-72-pcs',
        //     'description' => 'Lakban bertuliskan Jangan Dibanting / Fragile. Wajib untuk packing barang pecah belah. Warna merah mencolok.',
        //     'price' => 680000,
        //     'stock' => 45,
        //     'is_active' => true,
        //     'is_featured' => true, // Tampil di Beranda
        //     'image' => 'images/Produk/lakban-fragile.jpg'
        // ]);

        // // Produk 3: Plastik Wrap 6 Roll
        // Produk::create([
        //     'Kategori_id' => $catPlastik->id,
        //     'nama' => 'Stretch Film / Plastik Wrap (Bundle 6 Roll)',
        //     'slug' => 'plastik-wrap-6-roll',
        //     'description' => 'Plastik wrapping industrial grade. Elastis dan tidak mudah sobek. Melindungi barang dari debu dan air.',
        //     'price' => 285000,
        //     'stock' => 100,
        //     'is_active' => true,
        //     'is_featured' => true, // Tampil di Beranda
        //     'image' => 'images/Produk/plastik-wrap.jpg'
        // ]);

        // // Produk 4: Bubble Mailer
        // Produk::create([
        //     'Kategori_id' => $catAmplop->id,
        //     'nama' => 'Bubble Mailer Putih Premium (Pack)',
        //     'slug' => 'bubble-mailer-putih',
        //     'description' => 'Amplop dengan lapisan bubble di dalamnya. Praktis, sudah ada lem perekat. Tahan air dan aman.',
        //     'price' => 45000,
        //     'stock' => 200,
        //     'is_active' => true,
        //     'is_featured' => true, // Tampil di Beranda
        //     'image' => 'images/Produk/bubble-mailer.jpg'
        // ]);

        // // Produk 5: Lakban Bening 6 Pcs (Opsional/Tambahan)
        // Produk::create([
        //     'Kategori_id' => $catLakban->id,
        //     'nama' => 'Lakban Bening Top Bond (Paket Hemat 6 Pcs)',
        //     'slug' => 'lakban-bening-6-pcs',
        //     'description' => 'Paket hemat lakban bening untuk kebutuhan rumah tangga atau toko kecil.',
        //     'price' => 55000,
        //     'stock' => 150,
        //     'is_active' => true,
        //     'is_featured' => false, // Tidak tampil di slider utama (biar pas 4 grid)
        //     'image' => 'images/Produk/lakban-bening-6.jpg'
        // ]);
    }
}