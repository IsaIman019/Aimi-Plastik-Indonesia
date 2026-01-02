<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up()
    {
        // PERBAIKAN: Membuat tabel 'order_items' (Bukan 'orders')
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel orders (Wajib ada agar tahu barang ini milik pesanan siapa)
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            
            // Relasi ke tabel products
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            
            $table->integer('quantity');     // Jumlah barang yang dibeli
            $table->decimal('price', 15, 2); // Harga barang saat transaksi terjadi
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};