<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up()
{
    Schema::create('promos', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Nama Promo (misal: Harbolnas)
        $table->enum('type', ['percent', 'fixed']); // Persen (%) atau Potongan Harga Tetap (Rp)
        $table->decimal('value', 15, 2); // Nilai diskon (misal: 10 untuk 10%, atau 5000 untuk Rp 5.000)
        $table->date('start_date');
        $table->date('end_date');
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
