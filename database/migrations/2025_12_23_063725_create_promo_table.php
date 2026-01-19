<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up()
{
    Schema::create('promo', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('kode'); 
        $table->enum('tipe', ['percent', 'fixed']);
        $table->decimal('jumlah', 15, 2); 
        $table->date('tanggal_mulai');
        $table->date('tanggal_selesai');
        $table->boolean('is_all_product')->default(false);
        $table->string('status')->default('ACTIVE');
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('promo');
    }
};
