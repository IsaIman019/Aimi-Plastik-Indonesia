<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Admin & Pelanggan
        User::create([
            'name' => 'Admin Aimi',
            'email' => 'admin@aimi.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Kantor Pusat Aimi Packaging'
        ]);

        User::create([
            'name' => 'Pelanggan Setia',
            'email' => 'user@aimi.com',
            'password' => Hash::make('password'),
            'role' => 'pelanggan',
            'phone' => '08987654321',
            'address' => 'Jl. Mawar No. 10, Surabaya'
        ]);

        // 2. Buat Kategori
        $catLakban = Category::create(['name' => 'Lakban & Perekat', 'slug' => 'lakban-perekat']);
        $catPlastik = Category::create(['name' => 'Plastik & Bubble', 'slug' => 'plastik-bubble']);
        $catAmplop = Category::create(['name' => 'Amplop & Mailer', 'slug' => 'amplop-mailer']);

        // 3. Buat Produk Real (Sesuai Gambar)
        
        // Produk 1: Lakban Bening 72pcs
        Product::create([
            'category_id' => $catLakban->id,
            'name' => 'Lakban Bening Daimaru (Dus isi 72 Pcs)',
            'slug' => 'lakban-bening-72-pcs',
            'description' => 'Lakban bening kualitas premium daya rekat kuat. Cocok untuk packing kardus standar. Harga grosir 1 dus isi 72 roll.',
            'price' => 650000, 
            'stock' => 50,
            'is_active' => true,
            'is_featured' => true, // Tampil di Beranda
            'image' => 'images/products/lakban-bening-72.jpg' // Path gambar
        ]);

        // Produk 2: Lakban Fragile 72pcs
        Product::create([
            'category_id' => $catLakban->id,
            'name' => 'Lakban Fragile Merah (Dus isi 72 Pcs)',
            'slug' => 'lakban-fragile-72-pcs',
            'description' => 'Lakban bertuliskan Jangan Dibanting / Fragile. Wajib untuk packing barang pecah belah. Warna merah mencolok.',
            'price' => 680000,
            'stock' => 45,
            'is_active' => true,
            'is_featured' => true, // Tampil di Beranda
            'image' => 'images/products/lakban-fragile.jpg'
        ]);

        // Produk 3: Plastik Wrap 6 Roll
        Product::create([
            'category_id' => $catPlastik->id,
            'name' => 'Stretch Film / Plastik Wrap (Bundle 6 Roll)',
            'slug' => 'plastik-wrap-6-roll',
            'description' => 'Plastik wrapping industrial grade. Elastis dan tidak mudah sobek. Melindungi barang dari debu dan air.',
            'price' => 285000,
            'stock' => 100,
            'is_active' => true,   
            'is_featured' => true, // Tampil di Beranda
            'image' => 'images/products/plastik-wrap.jpg'
        ]);

        // Produk 4: Bubble Mailer
        Product::create([
            'category_id' => $catAmplop->id,
            'name' => 'Bubble Mailer Putih Premium (Pack)',
            'slug' => 'bubble-mailer-putih',
            'description' => 'Amplop dengan lapisan bubble di dalamnya. Praktis, sudah ada lem perekat. Tahan air dan aman.',
            'price' => 45000,
            'stock' => 200,
            'is_active' => true,
            'is_featured' => true, // Tampil di Beranda
            'image' => 'images/products/bubble-mailer.jpg'
        ]);

        // Produk 5: Lakban Bening 6 Pcs (Opsional/Tambahan)
        Product::create([
            'category_id' => $catLakban->id,
            'name' => 'Lakban Bening Top Bond (Paket Hemat 6 Pcs)',
            'slug' => 'lakban-bening-6-pcs',
            'description' => 'Paket hemat lakban bening untuk kebutuhan rumah tangga atau toko kecil.',
            'price' => 55000,
            'stock' => 150,
            'is_active' => true,
            'is_featured' => false, // Tidak tampil di slider utama (biar pas 4 grid)
            'image' => 'images/products/lakban-bening-6.jpg'
        ]);
    }
}