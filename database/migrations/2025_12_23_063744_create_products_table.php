<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel categories
            // Pastikan tabel categories sudah dibuat sebelum tabel ini!
            $table->foreignId('category_id')
                  ->constrained('categories') 
                  ->cascadeOnDelete();

            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            
            // Harga (Desimal untuk presisi, 15 digit, 2 angka belakang koma)
            $table->decimal('price', 15, 2);
            
            // Stok Barang (PENTING untuk marketplace)
            $table->integer('stock')->default(0);

            // Foto Produk (PENTING untuk tampilan katalog)
            $table->string('image')->nullable();

            // Status Produk
            $table->boolean('is_active')->default(true); // true = dijual, false = disembunyikan
            
            // Produk Unggulan
            // Jika true, produk ini akan muncul di slider/banner halaman depan
            $table->boolean('is_featured')->default(false); 

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};